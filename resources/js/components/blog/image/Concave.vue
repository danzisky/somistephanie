<template>
    <figure class="">
        <img :src="src" fetchpriority="high" class="rounded-t-[50%] rounded-b-lg border-10 border-somi-white shadow-somi object-cover w-full h-full">
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