<script setup lang="ts">
withDefaults(
    defineProps<{
        label?: string | null;
    }>(),
    { label: 'SOMI' },
);
</script>

<template>
    <div class="somi-art-placeholder" role="img" :aria-label="label ?? 'Decorative image'">
        <span>{{ label }}</span>
    </div>
</template>
