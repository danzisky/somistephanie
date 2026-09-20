<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer
        class="mx-auto mt-auto flex w-full max-w-[1180px] flex-wrap items-center justify-between gap-4 border-t border-somi-line px-6 py-10"
    >
        <div>
            <span class="font-serif text-lg font-semibold text-somi-plum">SOMI</span>
            <p class="mt-1 text-sm text-somi-plum-soft">Stories of my identities.</p>
        </div>
        <div class="flex gap-5 text-sm text-somi-plum-soft">
            <Link href="/contents" class="hover:text-somi-plum">Contents</Link>
            <Link href="/subscribe" class="hover:text-somi-plum">Subscribe</Link>
            <Link href="/shop" class="hover:text-somi-plum">Shop</Link>
            <a href="mailto:hello@somi.ie" class="hover:text-somi-plum">Contact</a>
        </div>
        <p class="w-full text-center text-xs text-somi-plum-soft">© {{ new Date().getFullYear() }} SOMI · Made for thoughtful reading.</p>
    </footer>
</template>
