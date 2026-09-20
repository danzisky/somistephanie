<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="somi-footer">
        <div class="somi-footer-brand">
            <span>SOMI</span>
            <p>Stories of my identities.</p>
        </div>
        <div class="somi-footer-links">
            <Link href="/contents">Contents</Link>
            <Link href="/subscribe">Subscribe</Link>
            <Link href="/shop">Shop</Link>
            <a href="mailto:hello@somi.ie">Contact</a>
        </div>
        <p class="somi-copyright">© {{ new Date().getFullYear() }} SOMI · Made for thoughtful reading.</p>
    </footer>
</template>
