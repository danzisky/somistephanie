<script setup lang="ts">
import { computed } from "vue";
import PlaceholderArt from "@/components/blog/PlaceholderArt.vue";
import ArticleHighlight from "@/components/blog/ArticleHighlight.vue";
import NewsletterForm from "@/components/blog/NewsletterForm.vue";
import NewsletterSignup from "@/components/blog/NewsletterSignup.vue";
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

    <section class="px-4 xl:mx-auto max-w-300 grid w-full items-center gap-12 px-6 py-14 pb-18 md:grid-cols-[1.05fr_0.95fr]">
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

    <section v-if="featured" class="px-4 xl:mx-auto max-w-300 mt-18 w-full">
        <ArticleHighlight :featured="featured" />
    </section>

    <section class="px-4 xl:mx-auto max-w-300 w-full py-12 font-sans sm:py-20 mt-14">
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

    <section class="px-4 xl:mx-auto max-w-300 w-full px-6 py-16" v-if="topics.length">
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

    <NewsletterSignup />
</template>
