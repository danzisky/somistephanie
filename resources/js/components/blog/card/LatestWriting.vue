<template>
    <a
        :href="href"
        :class="[
            'group flex flex-col overflow-hidden rounded-4xl transition-transform duration-300 ease-out hover:-translate-y-1',
            blogCardThemeClasses[theme],
        ]"
    >
        <div v-if="image" class="h-full max-h-3/7 overflow-hidden">
            <img
                :src="image"
                :alt="title"
                class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
                loading="lazy"
            />
        </div>

        <div
            class="flex h-full flex-col justify-between p-5 sm:p-6 md:p-7 lg:p-8"
        >
            <div>
                <div
                    class="mb-3 text-[10px] font-semibold tracking-[0.2em] text-[#9e7c95] uppercase sm:text-xs"
                >
                    <span v-if="category">{{ category }}</span>
                    <span v-if="category && readTime"> &bull; </span>
                    <span v-if="readTime">{{ readTime }}</span>
                </div>

                <h3
                    class="font-serif text-[clamp(2rem,2.4vw,3.4rem)] leading-[1.08] font-normal tracking-tight text-[#2c1d2e] transition-colors group-hover:text-[#533755]"
                >
                    {{ title }}
                </h3>

                <p
                    v-if="excerpt"
                    class="mt-3 text-sm leading-relaxed text-[#655366] sm:text-[15px]"
                >
                    {{ excerpt }}
                </p>
            </div>

            <div class="mt-6 pt-2">
                <span
                    class="inline-flex items-center gap-1 text-[10px] font-bold tracking-[0.2em] text-[#655366] uppercase transition-colors group-hover:text-[#2c1d2e] sm:text-xs"
                >
                    Read story
                    <span
                        aria-hidden="true"
                        class="text-sm transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                        >↗</span
                    >
                </span>
            </div>
        </div>
    </a>
</template>

<script setup lang="ts">
import { blogCardThemeClasses, type BlogCardTheme } from '@/config/blog';

withDefaults(
    defineProps<{
        title: string;
        category?: string;
        readTime?: string;
        excerpt?: string;
        href: string;
        image?: string | null;
        theme?: BlogCardTheme;
    }>(),
    {
        theme: 'rose',
    },
);
</script>
