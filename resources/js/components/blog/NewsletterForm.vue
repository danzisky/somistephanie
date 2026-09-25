<script setup lang="ts">
import { ref } from 'vue';

const { fieldId = 'newsletter-email', buttonText = 'Join the list', placeholder = 'you@example.com', variant = 'default' } = defineProps<{
    fieldId?: string;
    buttonText?: string;
    placeholder?: string;
    variant?: 'default' | 'signup';
}>();

type Status = 'idle' | 'submitting' | 'success' | 'error';

const email = ref('');
const honey = ref('');
const status = ref<Status>('idle');
const message = ref('');

function csrfToken(): string {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
}

async function submit() {
    if (status.value === 'submitting') {
        return;
    }

    status.value = 'submitting';
    message.value = '';

    try {
        const response = await fetch('/!/forms/newsletter', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken(),
            },
            body: JSON.stringify({ email: email.value, honey: honey.value }),
        });

        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            const firstError = Object.values(payload.error ?? {})[0];
            throw new Error(typeof firstError === 'string' ? firstError : 'Something went wrong. Please try again.');
        }

        status.value = 'success';
        message.value = 'You are on the list. Thank you for being here.';
        email.value = '';
    } catch (error) {
        status.value = 'error';
        message.value = error instanceof Error ? error.message : 'Something went wrong. Please try again.';
    }
}
</script>

<template>
    <form :class="variant === 'signup' ? 'mt-8 max-w-xl' : 'mt-6 max-w-[460px]'" @submit.prevent="submit">
        <label
            :for="fieldId"
            :class="variant === 'signup'
                ? 'mb-3 block text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs'
                : 'mb-2 block text-sm font-semibold text-somi-plum-soft'"
        >Email address</label>
        <div
            :class="variant === 'signup'
                ? 'flex items-center overflow-hidden rounded-full border border-[#d6b9b5] bg-[#f9f5f4] shadow-[0_1px_0_rgba(58,44,42,0.04)]'
                : 'flex gap-2.5'"
        >
            <input
                :id="fieldId"
                v-model="email"
                type="email"
                :placeholder="placeholder"
                required
                autocomplete="email"
                :class="variant === 'signup'
                    ? 'w-full min-w-0 bg-transparent px-5 py-4 text-base text-[#3a2c2a] placeholder:text-[#9a7b83] focus:outline-none'
                    : 'flex-1 rounded-full border border-somi-line bg-somi-white px-[18px] py-[14px] text-sm text-somi-plum focus:outline-2 focus:outline-somi-blush-deep focus:outline-offset-2'"
            />
            <button
                type="submit"
                :class="variant === 'signup'
                    ? 'shrink-0 rounded-full bg-[#5f4054] px-6 py-3.5 text-sm font-medium text-white transition-colors hover:bg-[#4d2f43] disabled:cursor-not-allowed disabled:opacity-60'
                    : 'inline-flex items-center gap-2 rounded-full bg-somi-plum px-7 py-[14px] text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose disabled:cursor-not-allowed disabled:opacity-60'"
                :disabled="status === 'submitting'"
            >
                {{ status === 'submitting' ? 'Joining…' : buttonText }}
            </button>
        </div>
        <!-- Honeypot: left empty by real visitors, hidden from view -->
        <input
            v-model="honey"
            type="text"
            name="honey"
            tabindex="-1"
            autocomplete="off"
            class="absolute -left-[9999px]"
            aria-hidden="true"
        />
        <small v-if="status !== 'success' && status !== 'error'" class="mt-2.5 block text-xs text-somi-plum-soft">No noise. Unsubscribe whenever you like.</small>
        <p v-else class="mt-2.5 text-sm font-medium" :class="status === 'success' ? 'text-green-700' : 'text-somi-rose'" role="status" aria-live="polite">
            {{ message }}
        </p>
    </form>
</template>
