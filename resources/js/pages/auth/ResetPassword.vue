<script setup>
import BaseButton from '@/components/BaseButton.vue';
import BaseDivider from '@/components/BaseDivider.vue';
import CardBox from '@/components/CardBox.vue';
import FormControl from '@/components/FormControl.vue';
import FormField from '@/components/FormField.vue';
import SectionFullScreen from '@/components/SectionFullScreen.vue';
import LayoutGuest from '@/layouts/LayoutGuest.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { mdiEmail, mdiFormTextboxPassword } from '@mdi/js';

const props = defineProps({
  email: {
    type: String,
    default: null,
  },
  token: {
    type: String,
    default: null,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <LayoutGuest>
    <Head title="Reset Password" />

    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">

        <FormField label="Email" label-for="email" help="Please enter your email" :error="form.errors.email">
          <FormControl
            v-model="form.email"
            :icon="mdiEmail"
            autocomplete="email"
            type="email"
            id="email"
            required
          />
        </FormField>

        <FormField label="Password" label-for="password" help="Please enter new password" :error="form.errors.password">
          <FormControl
            v-model="form.password"
            :icon="mdiFormTextboxPassword"
            type="password"
            autocomplete="new-password"
            id="password"
            required
          />
        </FormField>

        <FormField
          label="Confirm Password"
          label-for="password_confirmation"
          help="Please confirm new password"
          :error="form.errors.password_confirmation"
        >
          <FormControl
            v-model="form.password_confirmation"
            :icon="mdiFormTextboxPassword"
            type="password"
            autocomplete="new-password"
            id="password_confirmation"
            required
          />
        </FormField>

        <BaseDivider />

        <BaseButton
          type="submit"
          color="info"
          label="Reset password"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        />
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
