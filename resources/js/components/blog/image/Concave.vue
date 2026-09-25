<template>
    <figure class="group">
        <img :src="src" fetchpriority="high" class="h-full w-full rounded-t-[50%] rounded-b-lg border-10 border-somi-white object-cover shadow-somi transition-transform duration-700 ease-out group-hover:scale-105">
        <slot/>
    </figure>
</template>

<script setup lang="ts">
defineProps<{
    src: string;
}>();
</script>

<style scoped>

</style>