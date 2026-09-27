<script setup lang="ts">
import { computed, h } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';

type SchemaData = Record<string, unknown>;

const props = withDefaults(defineProps<{
    title: string;
    description: string;
    image?: string | null;
    schemaType?: 'WebPage' | 'WebSite' | 'BlogPosting';
    schema?: SchemaData;
    noindex?: boolean;
}>(), {
    image: '/images/somi-hero-v2.webp',
    schemaType: 'WebPage',
    noindex: false,
});

const page = usePage();
const seo = computed(() => page.props.seo as { siteUrl: string; siteName: string });
const siteUrl = computed(() => seo.value.siteUrl.replace(/\/$/, ''));
const canonicalUrl = computed(() => {
    const path = page.url.split(/[?#]/, 1)[0] || '/';

    return new URL(path, `${siteUrl.value}/`).toString();
});
const imageUrl = computed(() => props.image ? new URL(props.image, `${siteUrl.value}/`).toString() : undefined);
const structuredData = computed(() => {
    const schema = {
        '@context': 'https://schema.org',
        '@type': props.schemaType,
        name: props.title,
        description: props.description,
        url: canonicalUrl.value,
        image: imageUrl.value,
        isPartOf: {
            '@type': 'WebSite',
            name: seo.value.siteName,
            url: `${siteUrl.value}/`,
        },
        publisher: {
            '@type': 'Organization',
            name: seo.value.siteName,
            url: `${siteUrl.value}/`,
        },
        ...(props.schemaType === 'BlogPosting' ? { mainEntityOfPage: canonicalUrl.value } : {}),
        ...props.schema,
    };

    return JSON.stringify(schema).replace(/[<>&]/g, (character) => ({
        '<': '\\u003c',
        '>': '\\u003e',
        '&': '\\u0026',
    })[character]!);
});
const jsonLdNode = () => h('script', {
    type: 'application/ld+json',
    'head-key': 'structured-data',
}, structuredData.value);
</script>

<template>
    <Head :title="title">
        <meta name="description" :content="description" head-key="description" />
        <link rel="canonical" :href="canonicalUrl" head-key="canonical" />
        <meta property="og:type" :content="schemaType === 'BlogPosting' ? 'article' : 'website'" head-key="og:type" />
        <meta property="og:site_name" :content="seo.siteName" head-key="og:site_name" />
        <meta property="og:title" :content="title" head-key="og:title" />
        <meta property="og:description" :content="description" head-key="og:description" />
        <meta property="og:url" :content="canonicalUrl" head-key="og:url" />
        <meta v-if="imageUrl" property="og:image" :content="imageUrl" head-key="og:image" />
        <meta name="twitter:card" content="summary_large_image" head-key="twitter:card" />
        <meta name="twitter:title" :content="title" head-key="twitter:title" />
        <meta name="twitter:description" :content="description" head-key="twitter:description" />
        <meta v-if="imageUrl" name="twitter:image" :content="imageUrl" head-key="twitter:image" />
        <meta v-if="noindex" name="robots" content="noindex, nofollow" head-key="robots" />
        <component :is="jsonLdNode" />
    </Head>
</template>