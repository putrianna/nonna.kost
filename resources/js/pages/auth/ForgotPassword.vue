<script setup>
import BaseButton from '@/components/BaseButton.vue';
import BaseDivider from '@/components/BaseDivider.vue';
import BaseLevel from '@/components/BaseLevel.vue';
import CardBox from '@/components/CardBox.vue';
import FormControl from '@/components/FormControl.vue';
import FormField from '@/components/FormField.vue';
import NotificationBarInCard from '@/components/NotificationBarInCard.vue';
import SectionFullScreen from '@/components/SectionFullScreen.vue';
import LayoutGuest from '@/layouts/LayoutGuest.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { mdiEmail } from '@mdi/js';
import { route } from 'ziggy-js';

defineProps({
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <LayoutGuest>
    <Head title="Forgot Password" />

    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">

        <NotificationBarInCard v-if="status" color="info">
          {{ status }}
        </NotificationBarInCard>

        <FormField>
          <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email
            you a password reset link that will allow you to choose a new one.
          </div>
        </FormField>

        <FormField label="Email" help="Please enter your email" :error="form.errors.email">
          <FormControl
            v-model="form.email"
            :icon="mdiEmail"
            autocomplete="email"
            type="email"
            required
          />
        </FormField>

        <BaseDivider />

        <BaseLevel>
          <BaseButton
            type="submit"
            color="info"
            label="Email link"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          />
          <Link :href="route('login')"> Back to login </Link>
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
