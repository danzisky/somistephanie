<script setup lang="ts">
import type { BlogArticleSummary } from '@/types/blog';
import { Link } from '@inertiajs/vue3';
import PlaceholderArt from './PlaceholderArt.vue';

defineProps<{
    article: BlogArticleSummary;
}>();
</script>

<template>
    <Link :href="`/article/${article.slug}`" class="somi-story-card">
        <img v-if="article.hero_image" :src="article.hero_image" :alt="article.hero_image_caption ?? article.title" loading="lazy" />
        <PlaceholderArt v-else :label="article.category" />
        <div class="somi-story-card-copy">
            <p class="somi-meta">{{ article.category }} · {{ article.read_time }} min read</p>
            <h3>{{ article.title }}</h3>
            <p>{{ article.standfirst }}</p>
            <span class="somi-card-link">Read story ↗</span>
        </div>
    </Link>
</template>
