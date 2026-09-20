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

    <section class="somi-subscribe-hero somi-wrap">
        <div>
            <p class="somi-eyebrow">Subscribe</p>
            <h1>Let the stories <em>find you</em>.</h1>
            <p>
                New essays, quiet reflections and the occasional behind-the-scenes note — straight to your inbox,
                never to your spam folder.
            </p>
            <NewsletterForm field-id="subscribe-email" />
        </div>
        <div class="somi-subscribe-visual">
            <PlaceholderArt label="SOMI" />
            <div class="somi-subscribe-card">
                <span>Membership</span>
                <strong>Join once, read forever</strong>
            </div>
        </div>
    </section>

    <section class="somi-membership somi-wrap">
        <div class="somi-section-heading">
            <p class="somi-eyebrow">Membership</p>
            <h2>Choose how close you want to be.</h2>
        </div>
        <div class="somi-plans">
            <article v-for="plan in plans" :key="plan.name" class="somi-plan" :class="{ 'somi-plan-featured': plan.featured }">
                <h3>{{ plan.name }}</h3>
                <p class="somi-price">{{ plan.price }} <span>{{ plan.cadence }}</span></p>
                <p class="somi-plan-description">{{ plan.description }}</p>
                <ul>
                    <li v-for="perk in plan.perks" :key="perk">{{ perk }}</li>
                </ul>
                <button type="button" class="somi-button" disabled title="Membership checkout is coming soon">
                    {{ plan.cta }}
                </button>
            </article>
        </div>
        <p class="somi-plan-note">
            Paid membership is coming soon alongside the SOMI shop. Join the free list today and we'll let you know the
            moment it opens.
        </p>
    </section>
</template>
