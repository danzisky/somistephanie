<script setup lang="ts">
import '../../css/blog.css';
import SiteFooter from '@/components/blog/SiteFooter.vue';
import SiteHeader from '@/components/blog/SiteHeader.vue';
</script>

<template>
    <div class="somi-app">
        <SiteHeader />
        <main>
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>
