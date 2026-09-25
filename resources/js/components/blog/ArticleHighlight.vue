<template>
  <div class="group w-full mx-auto overflow-hidden rounded-4xl bg-[#f2ecf9] text-[#523d4f] font-sans shadow-sm transition-transform duration-300 ease-out hover:-translate-y-1 flex flex-col md:flex-row h-[70vh]">
    <!-- Left Column: Image Section -->
    <div class="relative w-full md:w-1/2">
      <img
        :src="props.featured?.hero_image ?? 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&q=80&w=1000'"
        :alt="props.featured?.hero_image_caption ?? 'Person looking in a mirror'"
        class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
      />
      <!-- Bottom Left Badge -->
      <div class="absolute bottom-5 left-5 bg-white/80 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider text-[#523d4f] uppercase shadow-sm">
        ON BECOMING / 2026
      </div>
    </div>

    <!-- Right Column: Content Section -->
    <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-between">
      <!-- Top Meta Info -->
      <div>
        <div class="flex items-center justify-between text-[11px] font-semibold tracking-widest uppercase text-[#9e83a0] mb-8">
          <span>FEATURED ESSAY</span>
          <span>NO. 01 / {{ props.featured?.category ?? '' }}</span>
        </div>

        <div class="text-[11px] font-semibold tracking-widest uppercase text-[#a27b8e] mb-4">
          {{ props.featured?.read_time ?? 0 }} MIN READ &bull; {{ props.featured?.views ?? 0 }} VIEWS
        </div>

        <!-- Title -->
        <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-normal leading-[1.1] text-[#2c1d2d] mb-6">
          {{ props.featured?.title ?? '' }}
        </h1>

        <!-- Subtitle/Description -->
        <p class="text-sm md:text-base text-[#70566d] leading-relaxed max-w-md font-light">
          {{ props.featured?.standfirst ?? '' }}
        </p>
      </div>

      <!-- Action Button -->
      <div class="mt-8">
        <a
          href="#"
          class="inline-flex items-center gap-2 border border-[#8f6d83] text-[#523d4f] px-5 py-2.5 rounded-full text-xs font-medium hover:bg-[#8f6d83] hover:text-white transition-colors duration-200"
        >
          Read the full story &rarr;
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  featured: {
    hero_image?: string | null;
    hero_image_caption?: string | null;
    title: string;
    standfirst: string;
    slug: string;
    category: string | null;
    read_time: number;
    views: number;
  } | null;
}>();
</script>

<style scoped>
/* Custom font imports if standard Tailwind serif/sans are insufficient */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

.font-serif {
  font-family: 'Playfair Display', Georgia, serif;
}

.font-sans {
  font-family: 'Plus Jakarta Sans', sans-serif;
}
</style>