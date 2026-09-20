<script setup lang="ts">
import type { BlogTopic } from '@/types/blog';
import { Link } from '@inertiajs/vue3';

defineProps<{
    topic: BlogTopic;
    index: number;
}>();
</script>

<template>
    <Link :href="`/contents?category=${topic.slug}`" class="somi-topic-pill">
        <span>{{ String(index + 1).padStart(2, '0') }}</span>
        <div>
            <h3>{{ topic.title }}</h3>
            <p>{{ topic.description }}</p>
        </div>
    </Link>
</template>
