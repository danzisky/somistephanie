<script setup lang="ts">
import ArchiveRow from '@/components/blog/ArchiveRow.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import type { BlogArticleSummary, BlogTopic } from '@/types/blog';
import { Head } from '@inertiajs/vue3';
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
        const matchesCategory = !activeCategory.value || article.category_slug === activeCategory.value;
        const matchesSearch =
            !term || article.title.toLowerCase().includes(term) || article.standfirst.toLowerCase().includes(term);

        return matchesCategory && matchesSearch;
    });
});
</script>

<template>
    <Head title="Contents">
        <meta name="description" content="Browse every SOMI essay by title, feeling or subject." />
    </Head>

    <section class="somi-page-intro somi-wrap">
        <div>
            <p class="somi-eyebrow">The archive</p>
            <h1>Contents</h1>
            <p>Find a piece by title, feeling or subject. Every essay has a place here.</p>
        </div>
        <PlaceholderArt label="SOMI" />
    </section>

    <section class="somi-contents somi-wrap">
        <div class="somi-contents-tools">
            <label>
                <span>Search the archive</span>
                <input v-model="search" placeholder="Search by title or idea…" type="search" />
            </label>
            <div class="somi-filters" aria-label="Filter articles by category">
                <button type="button" :class="{ 'somi-active': !activeCategory }" @click="activeCategory = null">All</button>
                <button
                    v-for="category in categories"
                    :key="category.slug"
                    type="button"
                    :class="{ 'somi-active': activeCategory === category.slug }"
                    @click="activeCategory = category.slug"
                >
                    {{ category.title }}
                </button>
            </div>
        </div>

        <p class="somi-result-count">{{ filtered.length }} {{ filtered.length === 1 ? 'piece' : 'pieces' }}</p>

        <div v-if="filtered.length" class="somi-archive-list">
            <ArchiveRow v-for="article in filtered" :key="article.id" :article="article" />
        </div>
        <p v-else class="somi-empty-state">No stories match your search yet. Try another word or category.</p>
    </section>
</template>
