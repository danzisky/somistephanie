<script setup lang="ts">
import type { BlogTopic } from '@/types/blog';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    topic: BlogTopic;
    index: number;
}>();

const palette = [
    'bg-[#e8c7cc]',
    'bg-[#dfe2f1]',
    'bg-[#e9dcc8]',
    'bg-[#dfeaf2]',
    'bg-[#dfeadb]',
];

const backgroundClass = palette[props.index % palette.length];
</script>

<template>
    <Link
        :href="`/contents?category=${topic.slug}`"
        class="group flex items-center gap-5 rounded-e-full rounded-s-full px-5 py-8 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-somi-sm"
        :class="backgroundClass"
    >
        <span class="w-12 shrink-0 text-right font-serif text-xl leading-none text-somi-plum-soft">
            {{ String(index + 1).padStart(2, '0') }}
        </span>

        <div class="flex-1 text-left">
            <h3 class="font-serif text-[clamp(1.6rem,2vw,3rem)] leading-[0.96] tracking-[-0.02em] text-somi-plum">
                {{ topic.title }}
            </h3>
            <p class="mt-1 text-sm text-somi-plum-soft">
                {{ topic.description }}
            </p>
        </div>
    </Link>
</template>
