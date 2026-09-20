<script setup lang="ts">
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Shop">
        <meta name="description" content="The SOMI shop is on its way." />
    </Head>

    <section class="mx-auto max-w-[640px] px-6 py-24 text-center">
        <div class="mx-auto mb-8 aspect-square w-[220px] overflow-hidden rounded-somi-lg shadow-somi">
            <PlaceholderArt label="SOMI" />
        </div>
        <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Coming soon</p>
        <h1 class="font-serif text-[clamp(2rem,3.6vw,2.8rem)] font-medium text-somi-plum">The shop is being written into being.</h1>
        <p class="mt-4 text-somi-plum-soft">
            Journals, prints and small good things for the many versions of you — arriving alongside SOMI's next
            chapter. For now, the stories are free and the newsletter is the best way to hear first.
        </p>
        <Link
            href="/subscribe"
            class="mt-7 inline-flex items-center gap-2 rounded-full bg-somi-plum px-7 py-[14px] text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose"
            >Join the newsletter</Link
        >
    </section>
</template>
