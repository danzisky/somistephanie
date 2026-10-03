<script setup lang="ts">
import ArchiveRow from '@/components/blog/ArchiveRow.vue';
import ArchiveFilters from '@/components/blog/ArchiveFilters.vue';
import SeoHead from '@/components/blog/SeoHead.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import type { BlogArticleSummary, BlogTopic } from '@/types/blog';
import { computed, ref } from 'vue';

const props = defineProps<{
    articles: BlogArticleSummary[];
    categories: BlogTopic[];
    initialCategory: string | null;
}>();

const search = ref('');
const activeCategory = ref<string | null>(props.initialCategory);

const filtered = computed(() => {
    const term = search.value.trim().toLowerCase();

    return props.articles.filter((article) => {
        const matchesCategory =
            !activeCategory.value ||
            article.category_slug === activeCategory.value;
        const matchesSearch =
            !term ||
            article.title.toLowerCase().includes(term) ||
            article.standfirst.toLowerCase().includes(term);

        return matchesCategory && matchesSearch;
    });
});
</script>

<template>
    <SeoHead
        title="Essays on Identity, Faith and Becoming | SOMI"
        description="Browse every SOMI essay by title, feeling or subject."
    />

    <section
        class="mx-auto grid w-full max-w-[1180px] items-center gap-10 px-6 py-14 pb-10 md:grid-cols-[1fr_0.4fr]"
    >
        <div>
            <p
                class="text-somi-rose mb-3 text-xs font-semibold tracking-[0.14em] uppercase"
            >
                The archive
            </p>
            <h1
                class="text-somi-plum font-serif text-[clamp(2rem,3.6vw,2.8rem)] font-medium"
            >
                Contents
            </h1>
            <p class="text-somi-plum-soft mt-4 max-w-[46ch]">
                Find a piece by title, feeling or subject. Every essay has a
                place here.
            </p>
        </div>
        <div class="rounded-somi-lg shadow-somi aspect-square overflow-hidden">
            <PlaceholderArt label="SOMI" />
        </div>
    </section>

    <section class="mx-auto w-full max-w-[1180px] px-6 pb-20">
        <ArchiveFilters
            v-model:search="search"
            v-model:active-category="activeCategory"
            :categories="categories"
        />

        <p class="text-somi-plum-soft mt-6 mb-2 text-sm">
            {{ filtered.length }}
            {{ filtered.length === 1 ? 'piece' : 'pieces' }}
        </p>

        <div v-if="filtered.length" class="flex flex-col">
            <ArchiveRow
                v-for="article in filtered"
                :key="article.id"
                :article="article"
            />
        </div>
        <p v-else class="text-somi-plum-soft py-[60px] text-center">
            No stories match your search yet. Try another word or category.
        </p>
    </section>
</template>
