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
    <form class="somi-newsletter-form" @submit.prevent="submit">
        <label :for="fieldId">Email address</label>
        <div class="somi-newsletter-form-row">
            <input
                :id="fieldId"
                v-model="email"
                type="email"
                placeholder="you@example.com"
                required
                autocomplete="email"
            />
            <button type="submit" class="somi-button" :disabled="status === 'submitting'">
                {{ status === 'submitting' ? 'Joining…' : 'Join the list' }}
            </button>
        </div>
        <!-- Honeypot: left empty by real visitors, hidden from view -->
        <input v-model="honey" type="text" name="honey" tabindex="-1" autocomplete="off" style="position: absolute; left: -9999px" aria-hidden="true" />
        <small v-if="status !== 'success' && status !== 'error'">No noise. Unsubscribe whenever you like.</small>
        <p v-else class="somi-form-note" :class="status === 'success' ? 'somi-success' : 'somi-error'">
            {{ message }}
        </p>
    </form>
</template>
