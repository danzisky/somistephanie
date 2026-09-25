<script setup lang="ts">
import { computed, ref } from 'vue';
import LatestWritingCard from '@/components/blog/card/LatestWriting.vue';
import NewsletterSignup from '@/components/blog/NewsletterSignup.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import type { BlogArticle, BlogArticleSummary } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    article: BlogArticle;
    related: BlogArticleSummary[];
    comments: BlogComment[];
}>();

interface BlogComment {
    id: string;
    name: string;
    comment: string;
    date: string;
}

const comments = ref([...props.comments]);
const name = ref('');
const email = ref('');
const comment = ref('');
const honey = ref('');
const commentStatus = ref<'idle' | 'submitting' | 'success' | 'error'>('idle');
const commentMessage = ref('');
const commentCount = computed(() => comments.value.length);

function csrfToken(): string {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
}

async function submitComment() {
    if (commentStatus.value === 'submitting') return;

    commentStatus.value = 'submitting';
    commentMessage.value = '';

    try {
        const response = await fetch(`/article/${props.article.slug}/comments`, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken(),
            },
            body: JSON.stringify({ name: name.value, email: email.value, comment: comment.value, honey: honey.value }),
        });
        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            const firstError = Object.values(payload.errors ?? {})[0];
            throw new Error(Array.isArray(firstError) ? firstError[0] : 'Please check your comment and try again.');
        }

        commentStatus.value = 'success';
        commentMessage.value = payload.message ?? 'Thank you. Your comment is awaiting approval.';
        name.value = '';
        email.value = '';
        comment.value = '';
    } catch (error) {
        commentStatus.value = 'error';
        commentMessage.value = error instanceof Error ? error.message : 'Something went wrong. Please try again.';
    }
}

const latestThemes = ['rose', 'lavender', 'yellow', 'blue'] as const;

function getTheme(index: number): (typeof latestThemes)[number] {
    return latestThemes[index % latestThemes.length];
}

function formatCount(value: number): string {
    return new Intl.NumberFormat('en-US').format(value);
}
</script>

<template>
    <Head :title="article.title">
        <meta name="description" :content="article.standfirst" />
    </Head>

    <article class="mx-auto w-full max-w-300 px-6">
        <header class="mx-auto py-14 pb-8">
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">{{ article.category }}</p>
            <h1 class="font-serif text-[clamp(2rem,4vw,3rem)] font-medium text-somi-plum">{{ article.title }}</h1>
            <p class="mt-2.5 max-w-[60ch] text-lg text-somi-plum-soft">{{ article.standfirst }}</p>
            <div class="mt-6 flex flex-wrap gap-4 text-sm text-somi-plum-soft">
                <span>By {{ article.author }}</span>
                <span>{{ article.date_formatted }}</span>
                <span>{{ article.read_time }} min read</span>
            </div>
        </header>

        <figure class="mx-auto">
            <div class="aspect-16/10 overflow-hidden rounded-somi-lg shadow-somi">
                <img
                    v-if="article.hero_image"
                    :src="article.hero_image"
                    :alt="article.hero_image_caption ?? article.title"
                    class="h-full w-full object-cover"
                />
                <PlaceholderArt v-else :label="article.category" />
            </div>
            <figcaption v-if="article.hero_image_caption" class="mt-3 text-center text-sm text-somi-plum-soft">{{ article.hero_image_caption }}</figcaption>
        </figure>

        <!-- eslint-disable-next-line vue/no-v-html -- content_html is rendered server-side from trusted Markdown authored in the CMS -->
        <div class="somi-essay-body mx-auto my-12 w-full text-[1.08rem]" v-html="article.content_html" />

        <div class="mx-auto flex w-full flex-wrap gap-4 border-t border-somi-line pt-6 pb-6">
            <span class="rounded-full border border-somi-line bg-somi-white px-5 py-2.5 text-sm text-somi-plum-soft">{{ formatCount(article.views) }} views</span>
            <span class="rounded-full border border-somi-line bg-somi-white px-5 py-2.5 text-sm text-somi-plum-soft">{{ formatCount(commentCount) }} comments</span>
        </div>
    </article>

    <section v-if="related.length" class="mx-auto w-full max-w-300 border-t border-somi-line px-6 py-14">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <p class="text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Keep reading</p>
            <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">Related stories</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <LatestWritingCard
                v-for="(item, index) in related.slice(0, 4)"
                :key="item.id"
                :title="item.title"
                :category="item.category ?? 'Essay'"
                :read-time="`${item.read_time} min read`"
                :excerpt="item.standfirst"
                :href="`/article/${item.slug}`"
                :image="item.hero_image"
                :theme="getTheme(index)"
            />
        </div>
    </section>

    <section class="mx-auto w-full max-w-300 border-t border-somi-line px-6 py-14 pb-18">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <p class="text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Reader thoughts</p>
            <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">{{ formatCount(commentCount) }} comments</h2>
        </div>

        <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
            <form class="flex flex-col gap-4" @submit.prevent="submitComment">
                <label class="flex flex-col gap-1.5 text-sm font-medium text-somi-plum-soft">
                    <span>Your name</span>
                    <input v-model="name" required maxlength="100" class="rounded-somi-sm border border-somi-line bg-somi-white p-4 font-sans text-sm text-somi-plum" />
                </label>
                <label class="flex flex-col gap-1.5 text-sm font-medium text-somi-plum-soft">
                    <span>Email address</span>
                    <input v-model="email" required type="email" maxlength="255" autocomplete="email" class="rounded-somi-sm border border-somi-line bg-somi-white p-4 font-sans text-sm text-somi-plum" />
                </label>
                <label class="flex flex-col gap-1.5 text-sm font-medium text-somi-plum-soft">
                    <span>Share a thought</span>
                    <textarea
                        v-model="comment"
                        rows="3"
                        placeholder="What did this piece stir up for you?"
                        required
                        maxlength="2000"
                        class="rounded-somi-sm border border-somi-line bg-somi-white p-4 font-sans text-sm text-somi-plum"
                    />
                </label>
                <button
                    type="submit"
                    class="self-start rounded-full bg-somi-plum px-7 py-3.5 text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="commentStatus === 'submitting'"
                >
                    {{ commentStatus === 'submitting' ? 'Sending…' : 'Post comment' }}
                </button>
                <input v-model="honey" type="text" tabindex="-1" autocomplete="off" class="absolute -left-[9999px]" aria-hidden="true" />
                <p v-if="commentStatus !== 'idle'" class="text-sm" :class="commentStatus === 'error' ? 'text-somi-rose' : 'text-green-700'">{{ commentMessage }}</p>
                <p v-else class="text-sm text-somi-plum-soft">Comments are reviewed before they appear publicly.</p>
            </form>

            <div class="flex flex-col gap-5">
                <template v-if="comments.length">
                    <div v-for="item in comments" :key="item.id" class="rounded-somi-sm border border-somi-line bg-somi-white p-5">
                        <div class="mb-2 flex justify-between gap-4 text-sm text-somi-plum-soft">
                            <strong class="text-somi-plum">{{ item.name }}</strong>
                            <span>{{ item.date }}</span>
                        </div>
                        <p class="text-somi-plum-soft">{{ item.comment }}</p>
                    </div>
                </template>
                <div v-else class="rounded-somi-sm border border-dashed border-somi-line p-5 text-sm text-somi-plum-soft">
                    No comments yet. Start the conversation.
                </div>
            </div>
        </div>
    </section>

    <NewsletterSignup
        eyebrow="Notes from SOMI"
        title="If this stayed with you, let more find you."
        field-id="article-email"
    />
</template>
