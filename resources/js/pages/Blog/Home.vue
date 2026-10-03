<script setup lang="ts">
import { computed } from 'vue';
import ArticleHighlight from '@/components/blog/ArticleHighlight.vue';
import NewsletterSignup from '@/components/blog/NewsletterSignup.vue';
import LatestWritingCard from '@/components/blog/card/LatestWriting.vue';
import TopicPill from '@/components/blog/TopicPill.vue';
import SeoHead from '@/components/blog/SeoHead.vue';
import SectionHeading from '@/components/blog/SectionHeading.vue';
import type { BlogArticleSummary, BlogTopic } from '@/types/blog';
import Concave from '@/components/blog/image/Concave.vue';
import { blogCardThemeAt, latestWritingLayoutClasses } from '@/config/blog';

const props = defineProps<{
    featured: BlogArticleSummary | null;
    latest: BlogArticleSummary[];
    topics: BlogTopic[];
}>();

const latestCards = computed(() => props.latest.slice(0, 4));
</script>

<template>
    <SeoHead
        title="SOMI | Personal Essays on Identity, Faith and Becoming"
        description="Personal essays and considered ideas on faith, ambition, culture, life and womanhood."
        schema-type="WebSite"
    />

    <section
        class="mx-auto grid w-full max-w-300 items-center gap-12 px-6 py-14 pb-18 md:grid-cols-[1.05fr_0.95fr]"
    >
        <div>
            <p
                class="text-somi-rose mb-3 text-xs font-semibold tracking-[0.14em] uppercase"
            >
                Stories of my identities
            </p>
            <h1
                class="text-somi-plum font-serif text-[clamp(2.8rem,5vw,6rem)] leading-none font-light tracking-tight"
            >
                A home for the
                <em class="text-somi-rose italic">many selves</em> we become.
            </h1>
            <p class="text-somi-plum-soft mt-5 max-w-[44ch] text-lg">
                Personal essays and tender ideas on faith, ambition, culture,
                womanhood and the beautifully unfinished work of becoming.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-6">
                <Link
                    href="/contents"
                    class="bg-somi-plum text-somi-white hover:bg-somi-rose inline-flex items-center gap-2 rounded-full px-7 py-3.5 text-sm font-medium transition-all hover:-translate-y-px"
                >
                    Explore the stories
                </Link>
                <Link
                    href="/subscribe"
                    class="text-somi-rose inline-flex items-center gap-1.5 text-sm font-medium hover:underline"
                >
                    Join the letters <span>↗</span>
                </Link>
            </div>
            <div class="mt-10 flex max-w-[32ch] items-start gap-3.5">
                <span class="text-somi-blush-deep font-serif text-2xl">01</span>
                <p class="text-somi-plum-soft text-sm">
                    Softness can hold a serious thought.
                </p>
            </div>
        </div>
        <div
            class="relative h-full"
            aria-label="A softly lit journal, flowers and pastel objects"
        >
            <Concave
                src="/images/somi-hero-v2.webp"
                alt="A journal and flowers in soft daylight"
                loading="eager"
                fetch-priority="high"
                class="relative aspect-[0.9] w-full"
            />
            <Concave
                src="/images/somi-reflection-v2.webp"
                alt="A quiet reflection detail"
                loading="lazy"
                class="absolute bottom-[20%] aspect-[0.9] w-[42%] -translate-x-1/2 rotate-[-4deg] hover:rotate-0 duration-300 ease-in-out"
            />

            <div
                class="absolute shadow-somi -right-2.5 bottom-[25%] flex rotate-4 flex-col gap-3 rounded-tr-2xl rounded-bl-2xl bg-[#f5eabf] p-4 hover:scale-105 hover:-rotate-12 duration-300 ease-in-out"
            >
                <span
                    class="text-somi-rose mb-1 block text-xs font-light tracking-[0.08em] uppercase"
                    >Vol. 01</span
                >
                <p class="font-serif text-lg font-light">
                    for every<br />version of you
                </p>
            </div>
        </div>
    </section>

    <section v-if="featured" class="mx-auto mt-18 w-full max-w-300 px-6">
        <ArticleHighlight :featured="featured" />
    </section>

    <section
        class="mx-auto mt-14 w-full max-w-300 px-6 py-12 font-sans sm:py-20"
    >
        <SectionHeading
            eyebrow="Fresh from the journal"
            title="Latest writing"
            size="large"
        >
            <Link
                href="/contents"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-[#655366] transition-colors hover:text-[#2c1d2e] sm:text-sm"
            >
                <span>All stories</span>
                <span
                    aria-hidden="true"
                    class="transition-transform group-hover:translate-x-1"
                    >→</span
                >
            </Link>
        </SectionHeading>

        <div
            v-if="latestCards.length"
            class="grid grid-cols-1 items-stretch gap-2 sm:gap-4 md:grid-cols-5"
        >
            <LatestWritingCard
                :class="latestWritingLayoutClasses[index]"
                v-for="(article, index) in latestCards"
                :key="article.id"
                :title="article.title"
                :category="article.category ?? 'Essay'"
                :read-time="`${article.read_time} min read`"
                :excerpt="article.standfirst"
                :href="`/article/${article.slug}`"
                :image="article.hero_image"
                :theme="blogCardThemeAt(index)"
                :is-feature="index === 0"
            />
        </div>
    </section>

    <section v-if="topics.length" class="mx-auto w-full max-w-300 px-6 py-16">
        <div class="grid items-start gap-8 md:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p
                    class="text-somi-rose mb-3 text-xs font-semibold tracking-[0.14em] uppercase"
                >
                    Wander by subject
                </p>
                <h2
                    class="text-somi-plum font-serif text-[clamp(3rem,5.2vw,7rem)] leading-[0.88] font-normal tracking-[-0.04em]"
                >
                    Choose what<br />feels close<br />today.
                </h2>
            </div>

            <div class="space-y-5">
                <TopicPill
                    v-for="(topic, index) in topics.slice(0, 5)"
                    :key="topic.slug"
                    :topic="topic"
                    :index="index"
                />
            </div>
        </div>
    </section>

    <NewsletterSignup />
</template>
