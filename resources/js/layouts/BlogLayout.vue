<script setup lang="ts">
import Lenis from 'lenis';
import { onBeforeUnmount, onMounted } from 'vue';
import '../../css/blog.css';
import SiteFooter from '@/components/blog/SiteFooter.vue';
import SiteHeader from '@/components/blog/SiteHeader.vue';

let lenis: Lenis | null = null;
let animationFrame = 0;

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    lenis = new Lenis({
        autoRaf: false,
        lerp: 0.1,
        smoothWheel: true,
    });

    const raf = (time: number) => {
        lenis?.raf(time);
        animationFrame = window.requestAnimationFrame(raf);
    };

    animationFrame = window.requestAnimationFrame(raf);
});

onBeforeUnmount(() => {
    window.cancelAnimationFrame(animationFrame);
    lenis?.destroy();
    lenis = null;
});
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
