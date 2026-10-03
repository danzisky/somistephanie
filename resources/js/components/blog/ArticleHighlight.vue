<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import type { BlogArticleSummary } from '@/types/blog';

defineProps<{
    featured: BlogArticleSummary | null;
}>();
</script>

<template>
    <article
        v-if="featured"
        class="group rounded-somi-lg bg-somi-white shadow-somi grid w-full overflow-hidden transition-transform duration-300 hover:-translate-y-1 md:min-h-[35rem] md:grid-cols-2"
    >
        <div
            class="bg-somi-cream-soft relative min-h-72 overflow-hidden md:min-h-full"
        >
            <img
                v-if="featured.hero_image"
                :src="featured.hero_image"
                :alt="featured.hero_image_caption ?? featured.title"
                loading="eager"
                fetchpriority="high"
                class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <PlaceholderArt v-else :label="featured.category ?? 'SOMI'" />
            <p
                class="bg-somi-white/90 text-somi-plum absolute bottom-5 left-5 rounded-full px-4 py-2 text-xs font-semibold tracking-wide uppercase shadow-sm"
            >
                Featured essay
            </p>
        </div>

        <div class="flex flex-col justify-between p-7 sm:p-10 md:p-12">
            <div>
                <p
                    class="text-somi-rose mb-5 text-xs font-semibold tracking-[0.14em] uppercase"
                >
                    {{ featured.category ?? 'Essay' }}
                    <span aria-hidden="true">·</span>
                    {{ featured.read_time }} min read
                </p>
                <h2
                    class="text-somi-plum font-serif text-[clamp(2rem,3vw,3.5rem)] leading-[1.04] font-medium"
                >
                    {{ featured.title }}
                </h2>
                <p
                    class="text-somi-plum-soft mt-5 max-w-[42ch] text-base leading-relaxed"
                >
                    {{ featured.standfirst }}
                </p>
                <div
                    class="text-somi-plum-soft mt-6 flex flex-wrap gap-3 text-xs"
                >
                    <span v-if="featured.track_views"
                        >{{
                            new Intl.NumberFormat('en-US').format(
                                featured.views,
                            )
                        }}
                        views</span
                    >
                    <span v-if="featured.show_comments_count"
                        >{{
                            new Intl.NumberFormat('en-US').format(
                                featured.comments_count,
                            )
                        }}
                        comments</span
                    >
                </div>
            </div>

            <Link
                :href="`/article/${featured.slug}`"
                class="border-somi-plum text-somi-plum hover:bg-somi-plum hover:text-somi-white mt-8 inline-flex w-fit items-center gap-2 rounded-full border px-5 py-3 text-sm font-medium transition-colors"
            >
                Read the full story <span aria-hidden="true">↗</span>
            </Link>
        </div>
    </article>
</template>
