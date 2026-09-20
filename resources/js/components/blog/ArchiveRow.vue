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
    <Link
        :href="`/article/${article.slug}`"
        class="group grid grid-cols-1 items-center gap-2 border-b border-somi-line py-6 md:grid-cols-[0.2fr_1fr_0.55fr] md:gap-6"
    >
        <p class="text-xs font-semibold tracking-wide text-somi-rose uppercase">{{ article.category }}</p>
        <div>
            <h2 class="mb-1.5 font-serif text-xl font-medium text-somi-plum transition-colors group-hover:text-somi-rose">{{ article.title }}</h2>
            <p class="text-sm text-somi-plum-soft">{{ article.standfirst }}</p>
        </div>
        <div class="flex flex-row flex-wrap gap-1 text-left text-xs text-somi-plum-soft md:flex-col md:text-right">
            <span>{{ article.date_formatted }}</span>
            <span>{{ article.read_time }} min read</span>
            <span>{{ formatCount(article.views) }} views</span>
            <span>{{ formatCount(article.comments_count) }} comments</span>
        </div>
    </Link>
</template>
