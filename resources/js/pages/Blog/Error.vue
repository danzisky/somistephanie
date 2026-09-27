<script setup lang="ts">
import SeoHead from '@/components/blog/SeoHead.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    status: number;
}>();

const isNotFound = props.status === 404;
</script>

<template>
    <SeoHead
        :title="isNotFound ? 'Page not found | SOMI' : 'Something went wrong | SOMI'"
        :description="isNotFound ? 'The page you were looking for could not be found.' : 'Something went wrong while loading this page.'"
        noindex
    />

    <main class="mx-auto grid min-h-[62vh] w-full max-w-7xl items-center gap-10 px-6 py-16 md:grid-cols-[1.05fr_0.95fr] md:gap-16 md:py-20">
        <section>
            <p class="mb-4 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">
                {{ isNotFound ? 'A little detour' : 'A pause in the story' }}
            </p>
            <p class="font-serif text-6xl leading-none text-somi-blush-deep" :aria-label="`Error ${status}`">{{ status }}</p>
            <h1 class="mt-5 max-w-[13ch] font-serif text-[clamp(2.2rem,5vw,4rem)] leading-[1.02] font-medium text-somi-plum">
                {{ isNotFound ? 'This page wandered off the page.' : 'We hit a pause mid-story.' }}
            </h1>
            <p class="mt-5 max-w-[48ch] text-base leading-relaxed text-somi-plum-soft">
                {{ isNotFound
                    ? 'The link may be out of date, or the page may have found a new home. Let’s get you back to something worth reading.'
                    : 'Something unexpected interrupted this page. Your place in the rest of SOMI is still here.' }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <Link
                    href="/"
                    class="inline-flex items-center justify-center rounded-full bg-somi-plum px-6 py-3 text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose"
                >
                    Back to home
                </Link>
                <Link
                    href="/contents"
                    class="inline-flex items-center justify-center rounded-full border border-somi-line bg-somi-white px-6 py-3 text-sm font-medium text-somi-plum transition-colors hover:border-somi-blush-deep"
                >
                    Browse contents
                </Link>
            </div>
        </section>

        <div
            class="relative flex aspect-4/3 min-h-65 items-center justify-center overflow-hidden bg-somi-cream-soft"
            role="img"
            :aria-label="isNotFound ? 'A quiet visual marker for a missing page' : 'A quiet visual marker for a page error'"
        >
            <div class="absolute inset-x-8 top-1/2 border-t border-somi-blush-deep/70" />
            <div class="absolute inset-y-8 left-1/2 border-l border-somi-blush-deep/70" />
            <span class="relative bg-somi-cream-soft px-5 font-serif text-[clamp(5rem,15vw,10rem)] leading-none text-somi-rose">
                {{ isNotFound ? 'lost' : 'breathe' }}
            </span>
            <span class="absolute bottom-5 right-6 text-[10px] font-semibold tracking-[0.2em] text-somi-plum-soft uppercase">
                SOMI · {{ status }}
            </span>
        </div>
    </main>
</template>