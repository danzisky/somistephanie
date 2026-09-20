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

    <section class="mx-auto grid w-full max-w-[1180px] items-center gap-10 px-6 py-14 pb-10 md:grid-cols-[1fr_0.4fr]">
        <div>
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">The archive</p>
            <h1 class="font-serif text-[clamp(2rem,3.6vw,2.8rem)] font-medium text-somi-plum">Contents</h1>
            <p class="mt-4 max-w-[46ch] text-somi-plum-soft">Find a piece by title, feeling or subject. Every essay has a place here.</p>
        </div>
        <div class="aspect-square overflow-hidden rounded-somi-lg shadow-somi">
            <PlaceholderArt label="SOMI" />
        </div>
    </section>

    <section class="mx-auto w-full max-w-[1180px] px-6 pb-20">
        <div class="flex flex-wrap items-center justify-between gap-5 border-t border-b border-somi-line py-6">
            <label>
                <span class="mb-1.5 block text-xs text-somi-plum-soft">Search the archive</span>
                <input
                    v-model="search"
                    placeholder="Search by title or idea…"
                    type="search"
                    class="min-w-[260px] rounded-full border border-somi-line bg-somi-white px-[18px] py-3 text-sm"
                />
            </label>
            <div class="flex flex-wrap gap-2.5" aria-label="Filter articles by category">
                <button
                    type="button"
                    class="rounded-full border border-somi-line bg-somi-white px-[18px] py-2 text-sm text-somi-plum-soft transition-colors hover:bg-somi-plum hover:text-somi-white"
                    :class="{ '!bg-somi-plum !text-somi-white': !activeCategory }"
                    @click="activeCategory = null"
                >
                    All
                </button>
                <button
                    v-for="category in categories"
                    :key="category.slug"
                    type="button"
                    class="rounded-full border border-somi-line bg-somi-white px-[18px] py-2 text-sm text-somi-plum-soft transition-colors hover:bg-somi-plum hover:text-somi-white"
                    :class="{ '!bg-somi-plum !text-somi-white': activeCategory === category.slug }"
                    @click="activeCategory = category.slug"
                >
                    {{ category.title }}
                </button>
            </div>
        </div>

        <p class="mt-6 mb-2 text-sm text-somi-plum-soft">{{ filtered.length }} {{ filtered.length === 1 ? 'piece' : 'pieces' }}</p>

        <div v-if="filtered.length" class="flex flex-col">
            <ArchiveRow v-for="article in filtered" :key="article.id" :article="article" />
        </div>
        <p v-else class="py-[60px] text-center text-somi-plum-soft">No stories match your search yet. Try another word or category.</p>
    </section>
</template>
