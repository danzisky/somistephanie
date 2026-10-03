<script setup lang="ts">
import NewsletterForm from '@/components/blog/NewsletterForm.vue';
import PlaceholderArt from '@/components/blog/PlaceholderArt.vue';
import SeoHead from '@/components/blog/SeoHead.vue';
import SectionHeading from '@/components/blog/SectionHeading.vue';
import { membershipPlanClasses, subscriptionPlans } from '@/config/blog';
</script>

<template>
    <SeoHead
        title="Newsletter | SOMI"
        description="Join SOMI's newsletter for new essays, quiet reflections and notes on faith, ambition, culture and becoming."
    />

    <section
        class="mx-auto grid w-full max-w-295 items-center gap-12 px-6 py-14 pb-18 md:grid-cols-2"
    >
        <div>
            <p
                class="text-somi-rose mb-3 text-xs font-semibold tracking-[0.14em] uppercase"
            >
                Subscribe
            </p>
            <h1
                class="text-somi-plum font-serif text-[clamp(2rem,3.6vw,2.8rem)] font-medium"
            >
                Let the stories <em class="text-somi-rose italic">find you</em>.
            </h1>
            <p class="text-somi-plum-soft mt-4 max-w-[46ch]">
                New essays, quiet reflections and the occasional
                behind-the-scenes note — straight to your inbox, never to your
                spam folder.
            </p>
            <NewsletterForm field-id="subscribe-email" />
        </div>
        <div class="relative">
            <div
                class="rounded-somi-lg shadow-somi aspect-16/10 overflow-hidden"
            >
                <PlaceholderArt label="SOMI" />
            </div>
            <div
                class="rounded-somi-md bg-somi-white shadow-somi absolute -bottom-6 -left-6 max-w-55 p-5"
            >
                <span
                    class="text-somi-rose mb-1.5 block text-xs font-semibold tracking-[0.08em] uppercase"
                    >Membership</span
                >
                <strong class="text-somi-plum font-serif font-medium"
                    >Join once, read forever</strong
                >
            </div>
        </div>
    </section>

    <section
        class="border-somi-line mx-auto w-full max-w-295 border-t px-6 py-16 pb-22"
    >
        <SectionHeading
            eyebrow="Membership"
            title="Choose how close you want to be."
        />
        <div class="grid grid-cols-1 gap-7 md:grid-cols-2">
            <article
                v-for="plan in subscriptionPlans"
                :key="plan.name"
                :class="[
                    membershipPlanClasses.card,
                    plan.featured && membershipPlanClasses.featuredCard,
                ]"
            >
                <h3 class="font-serif text-xl font-medium">{{ plan.name }}</h3>
                <p class="my-3.5 font-serif text-3xl">
                    {{ plan.price }}
                    <span class="font-sans text-sm font-normal opacity-70">{{
                        plan.cadence
                    }}</span>
                </p>
                <p
                    class="mb-5 text-sm"
                    :class="
                        plan.featured
                            ? membershipPlanClasses.featuredDescription
                            : membershipPlanClasses.description
                    "
                >
                    {{ plan.description }}
                </p>
                <ul class="mb-6 flex flex-col gap-2.5 text-sm">
                    <li v-for="perk in plan.perks" :key="perk">
                        <span class="opacity-60">— </span>{{ perk }}
                    </li>
                </ul>
                <button
                    type="button"
                    :class="[
                        membershipPlanClasses.button,
                        plan.featured && membershipPlanClasses.featuredButton,
                    ]"
                    disabled
                    title="Membership checkout is coming soon"
                >
                    {{ plan.cta }}
                </button>
            </article>
        </div>
        <p class="text-somi-plum-soft mt-8 text-center text-sm">
            Paid membership is coming soon alongside the SOMI shop. Join the
            free list today and we'll let you know the moment it opens.
        </p>
    </section>
</template>
