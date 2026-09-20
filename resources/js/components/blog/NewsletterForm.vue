<script setup lang="ts">
import { ref } from 'vue';

const { fieldId = 'newsletter-email' } = defineProps<{
    fieldId?: string;
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
    <form class="mt-6 max-w-[460px]" @submit.prevent="submit">
        <label :for="fieldId" class="mb-2 block text-sm font-semibold text-somi-plum-soft">Email address</label>
        <div class="flex gap-2.5">
            <input
                :id="fieldId"
                v-model="email"
                type="email"
                placeholder="you@example.com"
                required
                autocomplete="email"
                class="flex-1 rounded-full border border-somi-line bg-somi-white px-[18px] py-[14px] text-sm text-somi-plum focus:outline-2 focus:outline-somi-blush-deep focus:outline-offset-2"
            />
            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-somi-plum px-7 py-[14px] text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose disabled:cursor-not-allowed disabled:opacity-60"
                :disabled="status === 'submitting'"
            >
                {{ status === 'submitting' ? 'Joining…' : 'Join the list' }}
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
        <p v-else class="mt-2.5 text-sm font-medium" :class="status === 'success' ? 'text-green-700' : 'text-somi-rose'">
            {{ message }}
        </p>
    </form>
</template>
