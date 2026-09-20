<script setup lang="ts">
import NewsletterForm from '@/components/blog/NewsletterForm.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import { Head } from '@inertiajs/vue3';

const plans = [
    {
        name: 'The Reader',
        price: '€0',
        cadence: 'forever',
        description: 'Every published essay, delivered to your inbox as it goes live.',
        perks: ['Weekly essays by email', 'Full access to the archive', 'The topic newsletter'],
        cta: 'Join for free',
    },
    {
        name: 'The Inner Pages',
        price: '€6',
        cadence: '/ month',
        description: 'For readers who want to go further — the unfinished thoughts, too.',
        perks: [
            'Everything in The Reader',
            'Members-only reflections',
            'Early access to new essays',
            'A say in what gets written next',
        ],
        cta: 'Become a member',
        featured: true,
    },
];
</script>

<template>
    <Head title="Subscribe">
        <meta name="description" content="Join SOMI's newsletter and membership — stories of my identities, delivered." />
    </Head>

    <section class="mx-auto grid w-full max-w-295 items-center gap-12 px-6 py-14 pb-18 md:grid-cols-2">
        <div>
            <p class="mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Subscribe</p>
            <h1 class="font-serif text-[clamp(2rem,3.6vw,2.8rem)] font-medium text-somi-plum">
                Let the stories <em class="text-somi-rose italic">find you</em>.
            </h1>
            <p class="mt-4 max-w-[46ch] text-somi-plum-soft">
                New essays, quiet reflections and the occasional behind-the-scenes note — straight to your inbox,
                never to your spam folder.
            </p>
            <NewsletterForm field-id="subscribe-email" />
        </div>
        <div class="relative">
            <div class="aspect-16/10 overflow-hidden rounded-somi-lg shadow-somi">
                <PlaceholderArt label="SOMI" />
            </div>
            <div class="absolute -bottom-6 -left-6 max-w-55 rounded-somi-md bg-somi-white p-5 shadow-somi">
                <span class="mb-1.5 block text-xs font-semibold tracking-[0.08em] text-somi-rose uppercase">Membership</span>
                <strong class="font-serif font-medium text-somi-plum">Join once, read forever</strong>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-295 border-t border-somi-line px-6 py-16 pb-22">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-6">
            <p class="text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase">Membership</p>
            <h2 class="font-serif text-[clamp(1.6rem,2.6vw,2.2rem)] font-medium text-somi-plum">Choose how close you want to be.</h2>
        </div>
        <div class="grid grid-cols-1 gap-7 md:grid-cols-2">
            <article
                v-for="plan in plans"
                :key="plan.name"
                class="rounded-somi-lg border border-somi-line bg-somi-white p-8"
                :class="{ 'border-somi-plum! bg-somi-plum! text-somi-white!': plan.featured }"
            >
                <h3 class="font-serif text-xl font-medium">{{ plan.name }}</h3>
                <p class="my-3.5 font-serif text-3xl">{{ plan.price }} <span class="font-sans text-sm font-normal opacity-70">{{ plan.cadence }}</span></p>
                <p class="mb-5 text-sm" :class="plan.featured ? 'text-somi-white' : 'text-somi-plum-soft'">{{ plan.description }}</p>
                <ul class="mb-6 flex flex-col gap-2.5 text-sm">
                    <li v-for="perk in plan.perks" :key="perk">
                        <span class="opacity-60">— </span>{{ perk }}
                    </li>
                </ul>
                <button
                    type="button"
                    class="w-full justify-center rounded-full bg-somi-plum px-7 py-3.5 text-center text-sm font-medium text-somi-white disabled:cursor-not-allowed"
                    :class="{ 'bg-somi-white! text-somi-plum! hover:bg-somi-blush!': plan.featured }"
                    disabled
                    title="Membership checkout is coming soon"
                >
                    {{ plan.cta }}
                </button>
            </article>
        </div>
        <p class="mt-8 text-center text-sm text-somi-plum-soft">
            Paid membership is coming soon alongside the SOMI shop. Join the free list today and we'll let you know the
            moment it opens.
        </p>
    </section>
</template>
