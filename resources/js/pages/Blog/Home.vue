<script setup lang="ts">
import { computed } from "vue";
import PlaceholderArt from "@/components/blog/PlaceholderArt.vue";
import ArticleHighlight from "@/components/blog/ArticleHighlight.vue";
import NewsletterForm from "@/components/blog/NewsletterForm.vue";
import LatestWritingCard from "@/components/blog/card/LatestWriting.vue";
import TopicPill from "@/components/blog/TopicPill.vue";
import type { BlogArticleSummary, BlogTopic } from "@/types/blog";
import Concave from "@/components/blog/image/Concave.vue";

const props = defineProps<{
    featured: BlogArticleSummary | null;
    latest: BlogArticleSummary[];
    topics: BlogTopic[];
}>();

const latestCards = computed(() => props.latest.slice(0, 4));
const latestThemes = ["rose", "lavender", "yellow", "blue"] as const;

function formatCount(value: number): string {
    return new Intl.NumberFormat("en-US").format(value);
}

function getTheme(index: number): (typeof latestThemes)[number] {
    return latestThemes[index % latestThemes.length];
}
</script>

<template>
    <Head title="SOMI — Stories of My Identities">
        <meta
            name="description"
            content="Personal essays and considered ideas on faith, ambition, culture, life and womanhood."
        />
    </Head>

    <section class="mx-auto max-w-300 grid w-full items-center gap-12 px-6 py-14 pb-18 md:grid-cols-[1.05fr_0.95fr]">
        <div>
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">
                Stories of my identities
            </p>
            <h1 class="font-serif text-[clamp(2.8rem,5vw,6rem)] leading-none font-light tracking-tight text-somi-plum">
                A home for the <em class="text-somi-rose italic">many selves</em> we become.
            </h1>
            <p class="mt-5 max-w-[44ch] text-lg text-somi-plum-soft">
                Personal essays and tender ideas on faith, ambition, culture, womanhood and the
                beautifully unfinished work of becoming.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-6">
                <Link
                    href="/contents"
                    class="inline-flex items-center gap-2 rounded-full bg-somi-plum px-7 py-3.5 text-sm font-medium text-somi-white transition-all hover:-translate-y-px hover:bg-somi-rose"
                >
                    Explore the stories
                </Link>
                <Link href="/subscribe" class="inline-flex items-center gap-1.5 text-sm font-medium text-somi-rose hover:underline">
                    Join the letters <span>↗</span>
                </Link>
            </div>
            <div class="mt-10 flex max-w-[32ch] items-start gap-3.5">
                <span class="font-serif text-2xl text-somi-blush-deep">01</span>
                <p class="text-sm text-somi-plum-soft">Softness can hold a serious thought.</p>
            </div>
        </div>
        <div class="relative h-full" aria-label="A softly lit journal, flowers and pastel objects">
            <Concave src="/images/somi-hero-v2.webp" class="relative aspect-[0.9] w-full">
                <div class="absolute -bottom-2 -right-2.5 flex rotate-4 flex-col gap-3 rounded-tr-2xl rounded-bl-2xl bg-[#f5eabf] p-4 shadow-somi">
                    <span class="mb-1 block text-xs font-light tracking-[0.08em] text-somi-rose uppercase">Vol. 01</span>
                    <p class="font-serif text-lg font-light">for every<br />version of you</p>
                </div>
            </Concave>
            <Concave src="/images/somi-reflection-v2.webp" class="absolute -bottom-8 -translate-x-1/2 aspect-[0.9] w-[42%] rotate-[-4deg]" />
        </div>
    </section>

    <section v-if="featured" class="mx-auto max-w-300 mt-18 w-full">
        <ArticleHighlight :featured="featured" />
    </section>

    <section class="mx-auto max-w-300 w-full py-12 font-sans sm:py-20 mt-14">
        <div class="mb-8 flex items-end justify-between sm:mb-12">
            <div>
                <p class="mb-2 text-[10px] font-semibold tracking-[0.25em] uppercase text-[#9e7c95] sm:text-xs">
                    FRESH FROM THE JOURNAL
                </p>
                <h2 class="font-serif text-3xl font-normal tracking-tight text-[#2c1d2e] sm:text-4xl md:text-5xl">
                    Latest writing
                </h2>
            </div>

            <Link href="/contents" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#655366] transition-colors hover:text-[#2c1d2e] sm:text-sm">
                <span>All stories</span>
                <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
            </Link>
        </div>

        <div v-if="latestCards.length" class="grid grid-cols-1 items-stretch gap-2 sm:gap-4 md:grid-cols-5">
            <LatestWritingCard
                :class="[[0, 3].includes(index) ? 'md:col-span-3' : 'md:col-span-2', index < 2 ? 'h-[55vh]' : '']"
                v-for="(article, index) in latestCards"
                :key="article.id"
                :title="article.title"
                :category="article.category ?? 'Essay'"
                :read-time="`${article.read_time} min read`"
                :excerpt="article.standfirst"
                :href="`/article/${article.slug}`"
                :image="index == 0 ? '/images/somi-reflection-v2.webp' : article.hero_image"
                :theme="getTheme(index)"
                :is-feature="index === 0"
            />
        </div>
    </section>

    <section class="mx-auto max-w-300 w-full px-6 py-16" v-if="topics.length">
        <div class="grid items-start gap-8 md:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">
                    Wander by subject
                </p>
                <h2 class="font-serif text-[clamp(3rem,5.2vw,7rem)] leading-[0.88] font-normal tracking-[-0.04em] text-somi-plum">
                    Choose what<br />feels close<br />today.
                </h2>
            </div>

            <div class="space-y-5">
                <TopicPill v-for="(topic, index) in topics.slice(0, 5)" :key="topic.slug" :topic="topic" :index="index" />
            </div>
        </div>
    </section>

    <section class="w-full bg-[#f3e7e1] px-6 py-16 sm:py-20">
        <div class="mx-auto grid max-w-6xl items-center gap-10 md:grid-cols-[0.85fr_1.15fr] md:gap-14">
            <div class="mx-auto w-full max-w-[430px]">
                <div class="overflow-hidden rounded-full border-[8px] border-white/80 bg-[#efe1d9] shadow-somi">
                    <div class="aspect-square bg-[radial-gradient(circle_at_center,_rgba(255,255,255,0.7),_rgba(255,255,255,0)_52%),linear-gradient(135deg,#e5d3d5,#d8dbe8_38%,#d9d7cc_66%,#e6d8ca)]">
                        <div class="h-full w-full bg-[radial-gradient(circle_at_35%_25%,rgba(255,255,255,0.8),transparent_18%),radial-gradient(circle_at_60%_38%,rgba(240,198,201,0.9),transparent_16%),radial-gradient(circle_at_48%_65%,rgba(209,215,232,0.8),transparent_15%),radial-gradient(circle_at_32%_70%,rgba(241,223,202,0.9),transparent_16%),linear-gradient(135deg,rgba(247,220,219,0.8),rgba(202,211,228,0.75),rgba(228,219,208,0.85),rgba(232,214,212,0.82))] opacity-90" />
                    </div>
                </div>
            </div>

            <div class="text-center md:text-left">
                <p class="mb-4 text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs">
                    Notes from SOMI
                </p>
                <h2 class="mx-auto max-w-[14ch] font-serif text-[clamp(2.8rem,4vw,6rem)] leading-[0.92] tracking-[-0.04em] text-[#2d232d] md:mx-0 md:max-w-[12ch]">
                    A little beauty for your inbox—and something honest to sit with.
                </h2>

                <div class="mt-8 max-w-xl">
                    <label for="home-email" class="mb-3 block text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs">
                        Email address
                    </label>
                    <div class="flex items-center overflow-hidden rounded-full border border-[#d6b9b5] bg-[#f9f5f4] shadow-[0_1px_0_rgba(58,44,42,0.04)]">
                        <input
                            id="home-email"
                            type="email"
                            placeholder="you@example.com"
                            class="w-full bg-transparent px-5 py-4 text-base text-[#3a2c2a] placeholder:text-[#9a7b83] focus:outline-none"
                        />
                        <button
                            type="button"
                            class="shrink-0 rounded-full bg-[#5f4054] px-6 py-3.5 text-sm font-medium text-white transition-colors hover:bg-[#4d2f43]"
                        >
                            Join the list
                        </button>
                    </div>
                    <p class="mt-3 text-sm text-[#6d5b6a]">No noise. Unsubscribe whenever you like.</p>
                </div>
            </div>
        </div>
    </section>
</template>
