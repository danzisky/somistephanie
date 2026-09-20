<script setup lang="ts">
import type { BlogTopic } from '@/types/blog';
import { Link } from '@inertiajs/vue3';

defineProps<{
    topic: BlogTopic;
    index: number;
}>();
</script>

<template>
    <Link
        :href="`/contents?category=${topic.slug}`"
        class="flex items-start gap-4 rounded-somi-md border border-somi-line bg-somi-white p-5 transition-all hover:-translate-y-0.5 hover:border-somi-blush-deep"
    >
        <span class="font-serif text-2xl text-somi-blush-deep">{{ String(index + 1).padStart(2, '0') }}</span>
        <div>
            <h3 class="text-base font-medium text-somi-plum">{{ topic.title }}</h3>
            <p class="mt-1.5 text-sm text-somi-plum-soft">{{ topic.description }}</p>
        </div>
    </Link>
</template>
