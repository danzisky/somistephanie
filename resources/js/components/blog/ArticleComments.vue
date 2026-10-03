<script setup lang="ts">
import { computed, ref } from 'vue';
import { feedbackClasses } from '@/config/blog';
import type { BlogComment } from '@/types/blog';

const props = defineProps<{
    slug: string;
    comments: BlogComment[];
    showCount: boolean;
}>();

const comments = ref([...props.comments]);
const name = ref('');
const email = ref('');
const comment = ref('');
const honey = ref('');
const status = ref<'idle' | 'submitting' | 'success' | 'error'>('idle');
const message = ref('');
const commentCount = computed(() => comments.value.length);
const feedbackClass = computed(() =>
    status.value === 'error' ? feedbackClasses.error : feedbackClasses.success,
);

function csrfToken(): string {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') ?? ''
    );
}

async function submitComment() {
    if (status.value === 'submitting') return;

    status.value = 'submitting';
    message.value = '';

    try {
        const response = await fetch(`/article/${props.slug}/comments`, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken(),
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                comment: comment.value,
                honey: honey.value,
            }),
        });
        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            const firstError = Object.values(payload.errors ?? {})[0];
            throw new Error(
                Array.isArray(firstError)
                    ? firstError[0]
                    : 'Please check your comment and try again.',
            );
        }

        status.value = 'success';
        message.value =
            payload.message ?? 'Thank you. Your comment is awaiting approval.';
        name.value = '';
        email.value = '';
        comment.value = '';
    } catch (error) {
        status.value = 'error';
        message.value =
            error instanceof Error
                ? error.message
                : 'Something went wrong. Please try again.';
    }
}
</script>

<template>
    <section
        class="border-somi-line mx-auto w-full max-w-300 border-t px-6 py-14 pb-18"
    >
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <p
                class="text-somi-rose text-xs font-semibold tracking-[0.14em] uppercase"
            >
                Reader thoughts
            </p>
            <h2
                class="text-somi-plum font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium"
            >
                {{
                    showCount
                        ? `${new Intl.NumberFormat('en-US').format(commentCount)} comments`
                        : 'Reader thoughts'
                }}
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
            <form class="flex flex-col gap-4" @submit.prevent="submitComment">
                <label
                    class="text-somi-plum-soft flex flex-col gap-1.5 text-sm font-medium"
                >
                    <span>Your name</span>
                    <input
                        v-model="name"
                        required
                        maxlength="100"
                        class="rounded-somi-sm border-somi-line bg-somi-white text-somi-plum border p-4 font-sans text-sm"
                    />
                </label>
                <label
                    class="text-somi-plum-soft flex flex-col gap-1.5 text-sm font-medium"
                >
                    <span>Email address</span>
                    <input
                        v-model="email"
                        required
                        type="email"
                        maxlength="255"
                        autocomplete="email"
                        class="rounded-somi-sm border-somi-line bg-somi-white text-somi-plum border p-4 font-sans text-sm"
                    />
                </label>
                <label
                    class="text-somi-plum-soft flex flex-col gap-1.5 text-sm font-medium"
                >
                    <span>Share a thought</span>
                    <textarea
                        v-model="comment"
                        rows="3"
                        placeholder="What did this piece stir up for you?"
                        required
                        maxlength="2000"
                        class="rounded-somi-sm border-somi-line bg-somi-white text-somi-plum border p-4 font-sans text-sm"
                    />
                </label>
                <button
                    type="submit"
                    class="bg-somi-plum text-somi-white hover:bg-somi-rose self-start rounded-full px-7 py-3.5 text-sm font-medium transition-colors disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="status === 'submitting'"
                >
                    {{ status === 'submitting' ? 'Sending…' : 'Post comment' }}
                </button>
                <input
                    v-model="honey"
                    type="text"
                    tabindex="-1"
                    autocomplete="off"
                    class="absolute -left-[9999px]"
                    aria-hidden="true"
                />
                <p
                    v-if="status !== 'idle'"
                    class="text-sm"
                    :class="feedbackClass"
                    role="status"
                    aria-live="polite"
                >
                    {{ message }}
                </p>
                <p v-else class="text-somi-plum-soft text-sm">
                    Comments are reviewed before they appear publicly.
                </p>
            </form>

            <div class="flex flex-col gap-5">
                <template v-if="comments.length">
                    <article
                        v-for="item in comments"
                        :key="item.id"
                        class="rounded-somi-sm border-somi-line bg-somi-white border p-5"
                    >
                        <div
                            class="text-somi-plum-soft mb-2 flex justify-between gap-4 text-sm"
                        >
                            <strong class="text-somi-plum">{{
                                item.name
                            }}</strong>
                            <span>{{ item.date }}</span>
                        </div>
                        <p class="text-somi-plum-soft">{{ item.comment }}</p>
                    </article>
                </template>
                <div
                    v-else
                    class="rounded-somi-sm border-somi-line text-somi-plum-soft border border-dashed p-5 text-sm"
                >
                    No comments yet. Start the conversation.
                </div>
            </div>
        </div>
    </section>
</template>
