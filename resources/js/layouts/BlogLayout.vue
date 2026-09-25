<script setup lang="ts">
import '../../css/blog.css';
import SiteFooter from '@/components/blog/SiteFooter.vue';
import SiteHeader from '@/components/blog/SiteHeader.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-somi-cream font-sans leading-relaxed text-somi-plum antialiased">
        <SiteHeader />
        <main class="w-full">
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>
