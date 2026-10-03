<script setup lang="ts">
import { sectionHeadingClasses } from '@/config/blog';

withDefaults(
    defineProps<{
        eyebrow: string;
        title: string;
        size?: keyof typeof sectionHeadingClasses.sizes;
    }>(),
    {
        size: 'compact',
    },
);
</script>

<template>
    <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
        <div>
            <p :class="sectionHeadingClasses.eyebrow">{{ eyebrow }}</p>
            <h2
                :class="[
                    sectionHeadingClasses.title,
                    sectionHeadingClasses.sizes[size],
                ]"
            >
                {{ title }}
            </h2>
        </div>
        <slot />
    </div>
</template>
