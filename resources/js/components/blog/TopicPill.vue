<script setup lang="ts">
import { topicPillBackgroundClasses } from '@/config/blog';
import type { BlogTopic } from '@/types/blog';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    topic: BlogTopic;
    index: number;
}>();

const backgroundClass =
    topicPillBackgroundClasses[props.index % topicPillBackgroundClasses.length];
</script>

<template>
    <Link
        :href="`/contents?category=${topic.slug}`"
        class="group hover:shadow-somi-sm flex items-center gap-5 rounded-s-full rounded-e-full px-5 py-8 transition-all duration-200 hover:-translate-y-0.5"
        :class="backgroundClass"
    >
        <span
            class="text-somi-plum-soft w-12 shrink-0 text-right font-serif text-xl leading-none"
        >
            {{ String(index + 1).padStart(2, '0') }}
        </span>

        <div class="flex-1 text-left">
            <h3
                class="text-somi-plum font-serif text-[clamp(1.6rem,2vw,3rem)] leading-[0.96] tracking-[-0.02em]"
            >
                {{ topic.title }}
            </h3>
            <p class="text-somi-plum-soft mt-1 text-sm">
                {{ topic.description }}
            </p>
        </div>
    </Link>
</template>
