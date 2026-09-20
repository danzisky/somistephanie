<script setup lang="ts">
withDefaults(
    defineProps<{
        label?: string | null;
    }>(),
    { label: 'SOMI' },
);
</script>

<template>
    <div
        class="flex h-full w-full items-center justify-center bg-gradient-to-br from-somi-blush to-somi-cream-soft p-3 text-center font-serif text-sm text-somi-plum-soft"
        role="img"
        :aria-label="label ?? 'Decorative image'"
    >
        <span>{{ label }}</span>
    </div>
</template>
