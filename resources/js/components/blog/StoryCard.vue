<script setup lang="ts">
import type { BlogArticleSummary } from '@/types/blog';
import { Link } from '@inertiajs/vue3';
import PlaceholderArt from './PlaceholderArt.vue';

defineProps<{
    article: BlogArticleSummary;
}>();
</script>

<template>
    <Link
        :href="`/article/${article.slug}`"
        class="flex flex-col gap-4 rounded-somi-md bg-somi-white p-5 shadow-somi-sm transition-all hover:-translate-y-1 hover:shadow-somi"
    >
        <div class="aspect-square overflow-hidden rounded-somi-sm">
            <img
                v-if="article.hero_image"
                :src="article.hero_image"
                :alt="article.hero_image_caption ?? article.title"
                loading="lazy"
                class="h-full w-full object-cover"
            />
            <PlaceholderArt v-else :label="article.category" />
        </div>
        <div class="flex flex-col gap-1.5">
            <p class="text-sm text-somi-plum-soft">{{ article.category }} · {{ article.read_time }} min read</p>
            <h3 class="font-serif text-lg font-medium text-somi-plum">{{ article.title }}</h3>
            <p class="text-sm text-somi-plum-soft">{{ article.standfirst }}</p>
            <span class="text-sm font-semibold text-somi-rose">Read story ↗</span>
        </div>
    </Link>
</template>
