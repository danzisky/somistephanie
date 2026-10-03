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
</script>

<template>
    <section class="bg-somi-cream-soft w-full px-6 py-16 sm:py-20">
        <div
            class="mx-auto grid max-w-6xl items-center gap-10 md:grid-cols-[0.85fr_1.15fr] md:gap-14"
        >
            <div class="mx-auto w-full max-w-[430px]">
                <div
                    class="bg-somi-cream shadow-somi overflow-hidden rounded-full border-[8px] border-white/80"
                >
                    <div class="newsletter-signup-art aspect-square" />
                </div>
            </div>

            <div class="text-center md:text-left">
                <p
                    class="text-somi-rose mb-4 text-[10px] font-semibold tracking-[0.25em] uppercase sm:text-xs"
                >
                    {{ eyebrow }}
                </p>
                <h2
                    class="text-somi-plum mx-auto max-w-[14ch] font-serif text-4xl leading-none sm:text-5xl md:mx-0 md:max-w-[12ch] md:text-6xl"
                >
                    {{ title }}
                </h2>

                <NewsletterForm
                    :field-id="fieldId"
                    :button-text="buttonText"
                    :placeholder="placeholder"
                    variant="signup"
                />
            </div>
        </div>
    </section>
</template>
