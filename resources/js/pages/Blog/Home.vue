<script setup lang="ts">
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import NewsletterForm from '@/components/blog/NewsletterForm.vue';
import StoryCard from '@/components/blog/StoryCard.vue';
import TopicPill from '@/components/blog/TopicPill.vue';
import type { BlogArticleSummary, BlogTopic } from '@/types/blog';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    featured: BlogArticleSummary | null;
    latest: BlogArticleSummary[];
    topics: BlogTopic[];
}>();

function formatCount(value: number): string {
    return new Intl.NumberFormat('en-US').format(value);
}
</script>

<template>
    <Head title="SOMI — Stories of My Identities">
        <meta name="description" content="Personal essays and considered ideas on faith, ambition, culture, life and womanhood." />
    </Head>

    <section class="mx-auto grid w-full max-w-295 items-center gap-12 px-6 py-14 pb-18 md:grid-cols-[1.05fr_0.95fr]">
        <div>
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Stories of my identities</p>
            <h1 class="font-serif text-[clamp(2.2rem,4vw,3.4rem)] leading-[1.15] font-medium tracking-tight text-somi-plum">
                A home for the <em class="text-somi-rose italic">many selves</em> we become.
            </h1>
            <p class="mt-5 max-w-[44ch] text-lg text-somi-plum-soft">
                Personal essays and tender ideas on faith, ambition, culture, womanhood and the beautifully unfinished
                work of becoming.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-6">
                <Link
                    href="/contents"
                    class="inline-flex items-center gap-2 rounded-full bg-somi-plum px-7 py-3.5 text-sm font-medium text-somi-white transition-all hover:-translate-y-px hover:bg-somi-rose"
                    >Explore the stories</Link
                >
                <Link href="/subscribe" class="inline-flex items-center gap-1.5 text-sm font-medium text-somi-rose hover:underline"
                    >Join the letters <span>↗</span></Link
                >
            </div>
            <div class="mt-10 flex max-w-[32ch] items-start gap-3.5">
                <span class="font-serif text-2xl text-somi-blush-deep">01</span>
                <p class="text-sm text-somi-plum-soft">Softness can hold a serious thought.</p>
            </div>
        </div>
        <div class="relative" aria-label="A softly lit journal, flowers and pastel objects">
            <figure class="aspect-16/10 overflow-hidden rounded-somi-lg bg-linear-to-br from-somi-blush to-somi-cream-soft shadow-somi" />
            <figure
                class="absolute -bottom-8 -left-8 aspect-4/5 w-[42%] overflow-hidden rounded-somi-lg border-[6px] border-somi-white bg-linear-to-br from-somi-cream-soft to-somi-blush shadow-somi"
            />
            <div class="absolute -top-4.5 -right-2.5 rounded-somi-md bg-somi-white p-4 text-sm shadow-somi">
                <span class="mb-1 block text-xs font-semibold tracking-[0.08em] text-somi-rose uppercase">Vol. 01</span>
                <strong class="font-serif font-medium">for every<br />version of you</strong>
            </div>
        </div>
    </section>

    <section v-if="featured" class="mx-auto grid w-full max-w-295 items-center gap-12 border-t border-somi-line px-6 py-16 md:grid-cols-[0.85fr_1.15fr]">
        <div class="aspect-4/5 overflow-hidden rounded-somi-lg shadow-somi">
            <img
                v-if="featured.hero_image"
                :src="featured.hero_image"
                :alt="featured.hero_image_caption ?? featured.title"
                class="h-full w-full object-cover"
            />
            <PlaceholderArt v-else :label="featured.category" />
        </div>
        <div>
            <div class="mb-7 flex flex-wrap items-end justify-between gap-6">
                <p class="text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Featured essay</p>
                <span class="text-sm font-medium text-somi-plum-soft">No. 01 / {{ featured.category }}</span>
            </div>
            <p class="text-sm text-somi-plum-soft">{{ featured.read_time }} min read · {{ formatCount(featured.views) }} views</p>
            <h2 class="mt-2.5 mb-3.5 font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">{{ featured.title }}</h2>
            <p class="text-somi-plum-soft">{{ featured.standfirst }}</p>
            <Link
                :href="`/article/${featured.slug}`"
                class="mt-6 inline-flex items-center gap-2 rounded-full bg-somi-blush px-7 py-3.5 text-sm font-medium text-somi-plum transition-colors hover:bg-somi-blush-deep hover:text-somi-white"
                >Read the full story <span>→</span></Link
            >
        </div>
    </section>

    <section class="mx-auto w-full max-w-295 border-t border-somi-line px-6 py-16">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Fresh from the journal</p>
                <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">Latest writing</h2>
            </div>
            <Link href="/contents" class="inline-flex items-center gap-1.5 text-sm font-medium text-somi-rose hover:underline">All stories <span>→</span></Link>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <StoryCard v-for="article in latest" :key="article.id" :article="article" />
        </div>
    </section>

    <section class="mx-auto w-full max-w-295 border-t border-somi-line px-6 py-16">
        <div>
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Wander by subject</p>
            <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">Choose what feels close today.</h2>
        </div>
        <div class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
            <TopicPill v-for="(topic, index) in topics" :key="topic.slug" :topic="topic" :index="index" />
        </div>
    </section>

    <section class="bg-somi-cream-soft px-6 py-18">
        <div class="mx-auto grid w-full max-w-295 items-center gap-12 md:grid-cols-[0.8fr_1.2fr]">
            <div class="aspect-square overflow-hidden rounded-somi-lg shadow-somi">
                <PlaceholderArt label="SOMI" />
            </div>
            <div>
                <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Notes from SOMI</p>
                <h2 class="max-w-[26ch] font-serif text-[clamp(1.5rem,2.4vw,2rem)] font-medium text-somi-plum">
                    A little beauty for your inbox—and something honest to sit with.
                </h2>
                <NewsletterForm field-id="home-email" />
            </div>
        </div>
    </section>
</template>
