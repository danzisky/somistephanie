<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { blogNavigationClasses } from '@/config/blog';

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
    <header
        class="bg-somi-cream/30 border-somi-line sticky top-0 z-40 w-full border-b backdrop-blur-sm"
    >
        <div
            class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-5"
        >
            <Link
                href="/"
                class="flex flex-col font-serif leading-none"
                aria-label="SOMI home"
            >
                <span
                    class="text-somi-plum text-3xl font-semibold tracking-wider"
                    >SOMI</span
                >
                <small
                    class="text-somi-plum-soft mt-1 font-sans text-[0.65rem] font-normal tracking-widest uppercase"
                    >Stories of my identities</small
                >
            </Link>

            <nav
                class="hidden items-center gap-7 text-sm font-medium md:flex"
                aria-label="Main navigation"
            >
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="text-somi-plum-soft hover:text-somi-plum transition-colors"
                    :class="{
                        [blogNavigationClasses.active]: isActive(link.href),
                    }"
                >
                    {{ link.label }}
                </Link>
                <Link
                    href="/subscribe"
                    class="bg-somi-plum text-somi-white hover:bg-somi-rose rounded-full px-5 py-2.5 transition-colors"
                    :class="{
                        [blogNavigationClasses.subscribeActive]:
                            currentUrl === '/subscribe',
                    }"
                >
                    Subscribe
                </Link>
            </nav>

            <div class="md:hidden">
                <button
                    type="button"
                    class="border-somi-line bg-somi-white rounded-full border px-4 py-2 text-sm"
                    :aria-expanded="mobileOpen"
                    aria-controls="somi-mobile-menu"
                    @click="mobileOpen = !mobileOpen"
                >
                    {{ mobileOpen ? 'Close' : 'Menu' }}
                </button>
            </div>
        </div>
        <div
            v-if="mobileOpen"
            id="somi-mobile-menu"
            class="bg-somi-blush/60 absolute right-0 bottom-0 z-100 m-2 flex w-max translate-y-full flex-col gap-4 rounded-3xl px-10 py-6 text-base font-medium"
        >
            <Link
                v-for="link in links"
                :key="link.href"
                :href="link.href"
                class="text-somi-plum-soft"
                @click="mobileOpen = false"
                >{{ link.label }}</Link
            >
            <Link
                href="/subscribe"
                class="text-somi-plum-soft"
                @click="mobileOpen = false"
                >Subscribe</Link
            >
        </div>
    </header>
</template>
