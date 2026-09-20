<script setup lang="ts">
import NewsletterForm from '@/components/blog/NewsletterForm.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import StoryCard from '@/components/blog/StoryCard.vue';
import type { BlogArticle, BlogArticleSummary } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

defineProps<{
    article: BlogArticle;
    related: BlogArticleSummary[];
}>();

function formatCount(value: number): string {
    return new Intl.NumberFormat('en-US').format(value);
}
</script>

<template>
    <Head :title="article.title">
        <meta name="description" :content="article.standfirst" />
    </Head>

    <article class="somi-essay somi-wrap">
        <header class="somi-essay-header">
            <p class="somi-eyebrow">{{ article.category }}</p>
            <h1>{{ article.title }}</h1>
            <p class="somi-standfirst">{{ article.standfirst }}</p>
            <div class="somi-byline">
                <span>By {{ article.author }}</span>
                <span>{{ article.date_formatted }}</span>
                <span>{{ article.read_time }} min read</span>
            </div>
        </header>

        <figure class="somi-essay-hero-image">
            <div class="somi-hero-media">
                <img v-if="article.hero_image" :src="article.hero_image" :alt="article.hero_image_caption ?? article.title" />
                <PlaceholderArt v-else :label="article.category" />
            </div>
            <figcaption v-if="article.hero_image_caption">{{ article.hero_image_caption }}</figcaption>
        </figure>

        <!-- eslint-disable-next-line vue/no-v-html -- content_html is rendered server-side from trusted Markdown authored in the CMS -->
        <div class="somi-essay-body" v-html="article.content_html" />

        <div class="somi-post-actions">
            <span>{{ formatCount(article.views) }} views</span>
            <span>{{ formatCount(article.comments_count) }} comments</span>
        </div>
    </article>

    <section v-if="related.length" class="somi-related somi-wrap">
        <div class="somi-section-heading">
            <p class="somi-eyebrow">Keep reading</p>
            <h2>Related stories</h2>
        </div>
        <div class="somi-related-grid">
            <StoryCard v-for="item in related" :key="item.id" :article="item" />
        </div>
    </section>

    <section class="somi-comments somi-wrap">
        <div class="somi-section-heading">
            <p class="somi-eyebrow">Reader thoughts</p>
            <h2>{{ formatCount(article.comments_count) }} comments</h2>
        </div>

        <div class="somi-comments-grid">
            <form class="somi-comment-form" @submit.prevent>
                <label>
                    <span>Share a thought</span>
                    <textarea rows="3" placeholder="What did this piece stir up for you?" disabled />
                </label>
                <button type="submit" class="somi-button" disabled title="Comments are coming soon">Post comment</button>
                <p class="somi-comment-note">Comments are read-only for now — join the newsletter to be notified when they open up.</p>
            </form>

            <div class="somi-comment-list">
                <div class="somi-comment">
                    <div>
                        <strong>Aisha</strong>
                        <span>2 days ago</span>
                    </div>
                    <p>This put words to something I've been feeling for months. Thank you for writing it so gently.</p>
                </div>
                <div class="somi-comment">
                    <div>
                        <strong>Nneka</strong>
                        <span>5 days ago</span>
                    </div>
                    <p>Reading this on my lunch break and I might need the rest of the afternoon to sit with it.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="somi-newsletter">
        <div class="somi-wrap somi-newsletter-grid">
            <div class="somi-newsletter-art">
                <PlaceholderArt label="SOMI" />
            </div>
            <div class="somi-newsletter-copy">
                <p class="somi-eyebrow">Notes from SOMI</p>
                <h2>If this stayed with you, let more find you.</h2>
                <NewsletterForm field-id="article-email" />
            </div>
        </div>
    </section>
</template>
