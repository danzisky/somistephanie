<script setup lang="ts">
import { archiveFilterClasses } from '@/config/blog';
import type { BlogTopic } from '@/types/blog';

defineProps<{
    search: string;
    activeCategory: string | null;
    categories: BlogTopic[];
}>();

const emit = defineEmits<{
    'update:search': [value: string];
    'update:activeCategory': [value: string | null];
}>();
</script>

<template>
    <div
        class="border-somi-line flex flex-wrap items-center justify-between gap-5 border-t border-b py-6"
    >
        <label>
            <span class="text-somi-plum-soft mb-1.5 block text-xs"
                >Search the archive</span
            >
            <input
                :value="search"
                placeholder="Search by title or idea…"
                type="search"
                class="border-somi-line bg-somi-white min-w-[260px] rounded-full border px-[18px] py-3 text-sm"
                @input="
                    emit(
                        'update:search',
                        ($event.target as HTMLInputElement).value,
                    )
                "
            />
        </label>
        <div
            class="flex flex-wrap gap-2.5"
            aria-label="Filter articles by category"
        >
            <button
                type="button"
                :class="[
                    archiveFilterClasses.button,
                    !activeCategory && archiveFilterClasses.selected,
                ]"
                :aria-pressed="!activeCategory"
                @click="emit('update:activeCategory', null)"
            >
                All
            </button>
            <button
                v-for="category in categories"
                :key="category.slug"
                type="button"
                :class="[
                    archiveFilterClasses.button,
                    activeCategory === category.slug &&
                        archiveFilterClasses.selected,
                ]"
                :aria-pressed="activeCategory === category.slug"
                @click="emit('update:activeCategory', category.slug)"
            >
                {{ category.title }}
            </button>
        </div>
    </div>
</template>
