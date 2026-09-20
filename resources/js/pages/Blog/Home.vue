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

    <section class="somi-hero somi-wrap">
        <div class="somi-hero-copy">
            <p class="somi-eyebrow">Stories of my identities</p>
            <h1>A home for the <em>many selves</em> we become.</h1>
            <p class="somi-hero-lede">
                Personal essays and tender ideas on faith, ambition, culture, womanhood and the beautifully unfinished
                work of becoming.
            </p>
            <div class="somi-hero-actions">
                <Link href="/contents" class="somi-button">Explore the stories</Link>
                <Link href="/subscribe" class="somi-text-link">Join the letters <span>↗</span></Link>
            </div>
            <div class="somi-mini-manifesto">
                <span>01</span>
                <p>Softness can hold a serious thought.</p>
            </div>
        </div>
        <div class="somi-hero-art" aria-label="A softly lit journal, flowers and pastel objects">
            <figure class="somi-hero-photo somi-hero-photo-main" />
            <figure class="somi-hero-photo somi-hero-photo-small" />
            <div class="somi-hero-note">
                <span>Vol. 01</span>
                <strong>for every<br />version of you</strong>
            </div>
        </div>
    </section>

    <section v-if="featured" class="somi-feature-story somi-wrap">
        <div class="somi-feature-visual">
            <img v-if="featured.hero_image" :src="featured.hero_image" :alt="featured.hero_image_caption ?? featured.title" />
            <PlaceholderArt v-else :label="featured.category" />
        </div>
        <div class="somi-feature-copy">
            <div class="somi-section-heading">
                <p class="somi-eyebrow">Featured essay</p>
                <span class="somi-issue">No. 01 / {{ featured.category }}</span>
            </div>
            <p class="somi-meta">{{ featured.read_time }} min read · {{ formatCount(featured.views) }} views</p>
            <h2>{{ featured.title }}</h2>
            <p>{{ featured.standfirst }}</p>
            <Link :href="`/article/${featured.slug}`" class="somi-button somi-button-soft">Read the full story <span>→</span></Link>
        </div>
    </section>

    <section class="somi-latest somi-wrap">
        <div class="somi-section-heading">
            <div>
                <p class="somi-eyebrow">Fresh from the journal</p>
                <h2>Latest writing</h2>
            </div>
            <Link href="/contents" class="somi-text-link">All stories <span>→</span></Link>
        </div>
        <div class="somi-story-grid">
            <StoryCard v-for="article in latest" :key="article.id" :article="article" />
        </div>
    </section>

    <section class="somi-topics somi-wrap">
        <div class="somi-topics-intro">
            <p class="somi-eyebrow">Wander by subject</p>
            <h2>Choose what feels close today.</h2>
        </div>
        <div class="somi-topic-cloud">
            <TopicPill v-for="(topic, index) in topics" :key="topic.slug" :topic="topic" :index="index" />
        </div>
    </section>

    <section class="somi-newsletter">
        <div class="somi-wrap somi-newsletter-grid">
            <div class="somi-newsletter-art">
                <PlaceholderArt label="SOMI" />
            </div>
            <div class="somi-newsletter-copy">
                <p class="somi-eyebrow">Notes from SOMI</p>
                <h2>A little beauty for your inbox—and something honest to sit with.</h2>
                <NewsletterForm field-id="home-email" />
            </div>
        </div>
    </section>
</template>
