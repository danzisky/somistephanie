<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const mobileOpen = ref(false);
const page = usePage();

const links = [
    { label: 'Contents', href: '/contents' },
    { label: 'Featured', href: '/article' },
    { label: 'Shop', href: '/shop' },
];

function isActive(href: string): boolean {
    return page.url === href || page.url.startsWith(`${href}/`);
}

const currentUrl = computed(() => page.url);
</script>

<template>
    <header class="somi-header">
        <Link href="/" class="somi-wordmark" aria-label="SOMI home">
            <span>SOMI</span>
            <small>Stories of my identities</small>
        </Link>

        <nav class="somi-main-nav" aria-label="Main navigation">
            <Link v-for="link in links" :key="link.href" :href="link.href" :class="{ 'somi-nav-active': isActive(link.href) }">
                {{ link.label }}
            </Link>
            <Link href="/subscribe" class="somi-nav-cta" :class="{ 'somi-nav-active': currentUrl === '/subscribe' }">Subscribe</Link>
        </nav>

        <div class="somi-mobile-nav">
            <button type="button" :aria-expanded="mobileOpen" aria-controls="somi-mobile-menu" @click="mobileOpen = !mobileOpen">
                {{ mobileOpen ? 'Close' : 'Menu' }}
            </button>
        </div>
    </header>

    <div v-if="mobileOpen" id="somi-mobile-menu" class="somi-mobile-panel">
        <Link v-for="link in links" :key="link.href" :href="link.href" @click="mobileOpen = false">{{ link.label }}</Link>
        <Link href="/subscribe" @click="mobileOpen = false">Subscribe</Link>
    </div>
</template>
