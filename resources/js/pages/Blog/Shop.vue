<script setup lang="ts">
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Shop">
        <meta name="description" content="The SOMI shop is on its way." />
    </Head>

    <section class="somi-shop-placeholder somi-wrap">
        <PlaceholderArt label="SOMI" />
        <p class="somi-eyebrow">Coming soon</p>
        <h1>The shop is being written into being.</h1>
        <p>
            Journals, prints and small good things for the many versions of you — arriving alongside SOMI's next
            chapter. For now, the stories are free and the newsletter is the best way to hear first.
        </p>
        <Link href="/subscribe" class="somi-button">Join the newsletter</Link>
    </section>
</template>
