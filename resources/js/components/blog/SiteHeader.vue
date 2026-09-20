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
    <header class="sticky top-0 z-40 mx-auto flex w-full max-w-295 items-center justify-between bg-somi-cream/30 px-6 py-5 backdrop-blur-sm">
        <Link href="/" class="flex flex-col font-serif leading-none" aria-label="SOMI home">
            <span class="text-2xl font-semibold tracking-wide text-somi-plum">SOMI</span>
            <small class="mt-1 font-sans text-[0.65rem] font-normal tracking-widest text-somi-plum-soft uppercase">Stories of my identities</small>
        </Link>

        <nav class="hidden items-center gap-7 text-sm font-medium md:flex" aria-label="Main navigation">
            <Link
                v-for="link in links"
                :key="link.href"
                :href="link.href"
                class="text-somi-plum-soft transition-colors hover:text-somi-plum"
                :class="{ 'text-somi-plum': isActive(link.href) }"
            >
                {{ link.label }}
            </Link>
            <Link
                href="/subscribe"
                class="rounded-full bg-somi-plum px-5 py-2.5 text-somi-white transition-colors hover:bg-somi-rose"
                :class="{ 'bg-somi-rose': currentUrl === '/subscribe' }"
            >
                Subscribe
            </Link>
        </nav>

        <div class="md:hidden">
            <button
                type="button"
                class="rounded-full border border-somi-line bg-somi-white px-4 py-2 text-sm"
                :aria-expanded="mobileOpen"
                aria-controls="somi-mobile-menu"
                @click="mobileOpen = !mobileOpen"
            >
                {{ mobileOpen ? 'Close' : 'Menu' }}
            </button>
        </div>
    </header>

    <div v-if="mobileOpen" id="somi-mobile-menu" class="flex flex-col gap-4 px-6 pb-6 text-base font-medium">
        <Link v-for="link in links" :key="link.href" :href="link.href" class="text-somi-plum-soft" @click="mobileOpen = false">{{ link.label }}</Link>
        <Link href="/subscribe" class="text-somi-plum-soft" @click="mobileOpen = false">Subscribe</Link>
    </div>
</template>
