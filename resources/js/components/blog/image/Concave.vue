<script setup lang="ts">
withDefaults(
    defineProps<{
        src: string;
        alt: string;
        loading?: 'eager' | 'lazy';
        fetchPriority?: 'high' | 'low' | 'auto';
    }>(),
    {
        loading: 'lazy',
        fetchPriority: 'auto',
    },
);
</script>

<template>
    <figure
        class="group border-somi-white shadow-somi relative overflow-hidden rounded-t-[50%] rounded-b-lg border-10"
    >
        <img
            :src="src"
            :alt="alt"
            :loading="loading"
            :fetchpriority="fetchPriority"
            class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
        />
        <slot />
    </figure>
</template>
