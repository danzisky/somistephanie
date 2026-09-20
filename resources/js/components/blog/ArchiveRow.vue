<script setup lang="ts">
import type { BlogArticleSummary } from '@/types/blog';
import { Link } from '@inertiajs/vue3';

defineProps<{
    article: BlogArticleSummary;
}>();

function formatCount(value: number): string {
    return new Intl.NumberFormat('en-US').format(value);
}
</script>

<template>
    <Link :href="`/article/${article.slug}`" class="somi-archive-row">
        <p class="somi-meta">{{ article.category }}</p>
        <div>
            <h2>{{ article.title }}</h2>
            <p>{{ article.standfirst }}</p>
        </div>
        <div class="somi-archive-meta">
            <span>{{ article.date_formatted }}</span>
            <span>{{ article.read_time }} min read</span>
            <span>{{ formatCount(article.views) }} views</span>
            <span>{{ formatCount(article.comments_count) }} comments</span>
        </div>
    </Link>
</template>
