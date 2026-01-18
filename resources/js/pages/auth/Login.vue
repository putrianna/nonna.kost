<script setup>
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from '@/components/BaseButtons.vue';
import BaseDivider from '@/components/BaseDivider.vue';
import BaseLevel from '@/components/BaseLevel.vue';
import CardBox from '@/components/CardBox.vue';
import FormCheckRadioGroup from '@/components/FormCheckRadioGroup.vue';
import FormControl from '@/components/FormControl.vue';
import FormField from '@/components/FormField.vue';
import NotificationBarInCard from '@/components/NotificationBarInCard.vue';
import SectionFullScreen from '@/components/SectionFullScreen.vue';
import LayoutGuest from '@/layouts/LayoutGuest.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { mdiAccount, mdiAsterisk } from '@mdi/js';

const props = defineProps({
  canResetPassword: Boolean,
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({
  login: '',
  password: '',
  remember: [],
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember && form.remember.length ? 'on' : '',
    }))
    .post(route('login'), {
      onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <LayoutGuest>
    <Head title="Login" />

    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <NotificationBarInCard color="info">
          Authentication Required 😌
        </NotificationBarInCard>

        <FormField label="Email or Username" label-for="login" help="Please enter your email or username" :error="form.errors.login">
          <FormControl
            v-model="form.login"
            :icon="mdiAccount"
            id="login"
            autocomplete="login"
            type="text"
            required
            autofocus
          />
        </FormField>

        <FormField label="Password" label-for="password" help="Please enter your password" :error="form.errors.password">
          <FormControl
            v-model="form.password"
            :icon="mdiAsterisk"
            type="password"
            id="password"
            autocomplete="current-password"
            required
          />
        </FormField>

        <FormCheckRadioGroup
          v-model="form.remember"
          name="remember"
          :options="{ remember: 'Remember' }"
        />

        <BaseDivider />

        <BaseLevel>
          <BaseButtons>
            <BaseButton
              type="submit"
              color="info"
              label="Login"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            />
            <BaseButton
              v-if="canResetPassword"
              :href="route('password.request')"
              color="info"
              outline
              label="Remind"
            />
          </BaseButtons>
          <!-- <Link :href="route('register')"> Register </Link> -->
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
