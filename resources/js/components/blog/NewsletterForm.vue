<script setup lang="ts">
import { computed, ref } from 'vue';
import { feedbackClasses, newsletterFormClasses } from '@/config/blog';

const {
    fieldId = 'newsletter-email',
    buttonText = 'Join the list',
    placeholder = 'you@example.com',
    variant = 'default',
} = defineProps<{
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
const styles = computed(() => newsletterFormClasses[variant]);
const feedbackClass = computed(() =>
    status.value === 'success'
        ? feedbackClasses.success
        : feedbackClasses.error,
);

function csrfToken(): string {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') ?? ''
    );
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
            throw new Error(
                typeof firstError === 'string'
                    ? firstError
                    : 'Something went wrong. Please try again.',
            );
        }

        status.value = 'success';
        message.value = 'You are on the list. Thank you for being here.';
        email.value = '';
    } catch (error) {
        status.value = 'error';
        message.value =
            error instanceof Error
                ? error.message
                : 'Something went wrong. Please try again.';
    }
}
</script>

<template>
    <form :class="styles.form" @submit.prevent="submit">
        <label :for="fieldId" :class="styles.label">Email address</label>
        <div :class="styles.fields">
            <input
                :id="fieldId"
                v-model="email"
                type="email"
                :placeholder="placeholder"
                required
                autocomplete="email"
                :class="styles.input"
            />
            <button
                type="submit"
                :class="styles.button"
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
        <small
            v-if="status !== 'success' && status !== 'error'"
            class="text-somi-plum-soft mt-2.5 block text-xs"
            >No noise. Unsubscribe whenever you like.</small
        >
        <p
            v-else
            class="mt-2.5 text-sm font-medium"
            :class="feedbackClass"
            role="status"
            aria-live="polite"
        >
            {{ message }}
        </p>
    </form>
</template>
