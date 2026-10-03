<script setup lang="ts">
import { computed } from 'vue';
import ArticleComments from '@/components/blog/ArticleComments.vue';
import LatestWritingCard from '@/components/blog/card/LatestWriting.vue';
import NewsletterSignup from '@/components/blog/NewsletterSignup.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import SectionHeading from '@/components/blog/SectionHeading.vue';
import SeoHead from '@/components/blog/SeoHead.vue';
import type {
    BlogArticle,
    BlogArticleSummary,
    BlogComment,
} from '@/types/blog';
import { blogCardThemeAt } from '@/config/blog';

const props = defineProps<{
    article: BlogArticle;
    related: BlogArticleSummary[];
    comments: BlogComment[];
}>();

const articleSchema = computed(() => ({
    headline: props.article.title,
    description: props.article.standfirst,
    datePublished: props.article.date ?? undefined,
    author: { '@type': 'Person', name: props.article.author },
    ...(props.article.category
        ? { articleSection: props.article.category }
        : {}),
}));

function formatCount(value: number): string {
    return new Intl.NumberFormat('en-US').format(value);
}
</script>

<template>
    <SeoHead
        :title="`${article.title} | SOMI`"
        :description="article.standfirst"
        :image="article.hero_image"
        schema-type="BlogPosting"
        :schema="articleSchema"
    />

    <article class="mx-auto w-full max-w-300 px-6">
        <header class="mx-auto py-14 pb-8">
            <p
                class="text-somi-rose mb-3 text-xs font-semibold tracking-[0.14em] uppercase"
            >
                {{ article.category }}
            </p>
            <h1
                class="text-somi-plum font-serif text-[clamp(2rem,4vw,3rem)] font-medium"
            >
                {{ article.title }}
            </h1>
            <p class="text-somi-plum-soft mt-2.5 max-w-[60ch] text-lg">
                {{ article.standfirst }}
            </p>
            <div class="text-somi-plum-soft mt-6 flex flex-wrap gap-4 text-sm">
                <span>By {{ article.author }}</span>
                <span>{{ article.date_formatted }}</span>
                <span>{{ article.read_time }} min read</span>
            </div>
        </header>

        <figure class="mx-auto">
            <div class="rounded-somi-lg aspect-16/10 overflow-hidden">
                <img
                    v-if="article.hero_image"
                    :src="article.hero_image"
                    :alt="article.hero_image_caption ?? article.title"
                    class="h-full w-full object-cover"
                />
                <PlaceholderArt v-else :label="article.category" />
            </div>
            <figcaption
                v-if="article.hero_image_caption"
                class="text-somi-plum-soft mt-3 text-center text-sm"
            >
                {{ article.hero_image_caption }}
            </figcaption>
        </figure>

        <!-- eslint-disable-next-line vue/no-v-html -- content_html is rendered server-side from trusted Markdown authored in the CMS -->
        <div
            class="somi-essay-body mx-auto my-12 w-full text-[1.08rem]"
            v-html="article.content_html"
        />

        <div
            class="border-somi-line mx-auto flex w-full flex-wrap gap-4 border-t pt-6 pb-6"
        >
            <span
                v-if="article.track_views"
                class="border-somi-line bg-somi-white text-somi-plum-soft rounded-full border px-5 py-2.5 text-sm"
                >{{ formatCount(article.views) }} views</span
            >
            <span
                v-if="article.show_comments_count"
                class="border-somi-line bg-somi-white text-somi-plum-soft rounded-full border px-5 py-2.5 text-sm"
                >{{ formatCount(props.comments.length) }} comments</span
            >
        </div>
    </article>

    <section
        v-if="related.length"
        class="border-somi-line mx-auto w-full max-w-300 border-t px-6 py-14"
    >
        <SectionHeading eyebrow="Keep reading" title="Related stories" />
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <LatestWritingCard
                v-for="(item, index) in related.slice(0, 4)"
                :key="item.id"
                :title="item.title"
                :category="item.category ?? 'Essay'"
                :read-time="`${item.read_time} min read`"
                :excerpt="item.standfirst"
                :href="`/article/${item.slug}`"
                :image="item.hero_image"
                :theme="blogCardThemeAt(index)"
            />
        </div>
    </section>

    <ArticleComments
        :slug="article.slug"
        :comments="comments"
        :show-count="article.show_comments_count"
    />

    <NewsletterSignup
        eyebrow="Notes from SOMI"
        title="If this stayed with you, let more find you."
        field-id="article-email"
    />
</template>
