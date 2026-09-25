<script setup lang="ts">
import LatestWritingCard from '@/components/blog/card/LatestWriting.vue';
import NewsletterSignup from '@/components/blog/NewsletterSignup.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import type { BlogArticle, BlogArticleSummary } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

defineProps<{
    article: BlogArticle;
    related: BlogArticleSummary[];
}>();

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
            <span class="rounded-full border border-somi-line bg-somi-white px-5 py-2.5 text-sm text-somi-plum-soft">{{ formatCount(article.comments_count) }} comments</span>
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
            <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">{{ formatCount(article.comments_count) }} comments</h2>
        </div>

        <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
            <form class="flex flex-col gap-4" @submit.prevent>
                <label class="flex flex-col gap-1.5 text-sm font-medium text-somi-plum-soft">
                    <span>Share a thought</span>
                    <textarea
                        rows="3"
                        placeholder="What did this piece stir up for you?"
                        disabled
                        class="rounded-somi-sm border border-somi-line bg-somi-white p-4 font-sans text-sm text-somi-plum"
                    />
                </label>
                <button
                    type="submit"
                    class="self-start rounded-full bg-somi-plum px-7 py-3.5 text-sm font-medium text-somi-white disabled:cursor-not-allowed disabled:opacity-60"
                    disabled
                    title="Comments are coming soon"
                >
                    Post comment
                </button>
                <p class="text-sm text-somi-plum-soft">Comments are read-only for now — join the newsletter to be notified when they open up.</p>
            </form>

            <div class="flex flex-col gap-5">
                <div class="rounded-somi-sm border border-somi-line bg-somi-white p-5">
                    <div class="mb-2 flex justify-between text-sm text-somi-plum-soft">
                        <strong class="text-somi-plum">Aisha</strong>
                        <span>2 days ago</span>
                    </div>
                    <p class="text-somi-plum-soft">This put words to something I've been feeling for months. Thank you for writing it so gently.</p>
                </div>
                <div class="rounded-somi-sm border border-somi-line bg-somi-white p-5">
                    <div class="mb-2 flex justify-between text-sm text-somi-plum-soft">
                        <strong class="text-somi-plum">Nneka</strong>
                        <span>5 days ago</span>
                    </div>
                    <p class="text-somi-plum-soft">Reading this on my lunch break and I might need the rest of the afternoon to sit with it.</p>
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
