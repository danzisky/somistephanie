<script setup lang="ts">
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

        <div class="mt-8 max-w-xl">
          <label :for="fieldId" class="mb-3 block text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs">
            Email address
          </label>
          <div class="flex items-center overflow-hidden rounded-full border border-[#d6b9b5] bg-[#f9f5f4] shadow-[0_1px_0_rgba(58,44,42,0.04)]">
            <input
              :id="fieldId"
              type="email"
              :placeholder="placeholder"
              class="w-full bg-transparent px-5 py-4 text-base text-[#3a2c2a] placeholder:text-[#9a7b83] focus:outline-none"
            />
            <button
              type="button"
              class="shrink-0 rounded-full bg-[#5f4054] px-6 py-3.5 text-sm font-medium text-white transition-colors hover:bg-[#4d2f43]"
            >
              {{ buttonText }}
            </button>
          </div>
          <p class="mt-3 text-sm text-[#6d5b6a]">No noise. Unsubscribe whenever you like.</p>
        </div>
      </div>
    </div>
  </section>
</template>
