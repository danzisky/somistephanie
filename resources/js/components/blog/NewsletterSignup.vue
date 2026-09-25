<script setup lang="ts">
import NewsletterForm from '@/components/blog/NewsletterForm.vue';

withDefaults(
  defineProps<{
    eyebrow?: string;
    title?: string;
    fieldId?: string;
    buttonText?: string;
    placeholder?: string;
  }>(),
  {
    eyebrow: 'Notes from SOMI',
    title: 'A little beauty for your inbox—and something honest to sit with.',
    fieldId: 'home-email',
    buttonText: 'Join the list',
    placeholder: 'you@example.com',
  },
);

const artStyle = {
  background:
    'radial-gradient(circle at center, rgba(255,255,255,0.7), rgba(255,255,255,0) 52%), linear-gradient(135deg, #e5d3d5, #d8dbe8 38%, #d9d7cc 66%, #e6d8ca)',
};
</script>

<template>
  <section class="w-full bg-[#f3e7e1] px-6 py-16 sm:py-20">
    <div class="mx-auto grid max-w-6xl items-center gap-10 md:grid-cols-[0.85fr_1.15fr] md:gap-14">
      <div class="mx-auto w-full max-w-[430px]">
        <div class="overflow-hidden rounded-full border-[8px] border-white/80 bg-[#efe1d9] shadow-somi">
          <div class="aspect-square" :style="artStyle" />
        </div>
      </div>

      <div class="text-center md:text-left">
        <p class="mb-4 text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs">
          {{ eyebrow }}
        </p>
        <h2 class="mx-auto max-w-[14ch] font-serif text-[clamp(2.8rem,4vw,6rem)] leading-[0.92] tracking-[-0.04em] text-[#2d232d] md:mx-0 md:max-w-[12ch]">
          {{ title }}
        </h2>

        <NewsletterForm :field-id="fieldId" :button-text="buttonText" :placeholder="placeholder" variant="signup" />
      </div>
    </div>
  </section>
</template>
