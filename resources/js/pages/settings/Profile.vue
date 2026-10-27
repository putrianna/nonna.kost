<script setup>
import { computed, ref, watch } from 'vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { mdiAccount, mdiMail, mdiAsterisk, mdiFormTextboxPassword, mdiCog } from '@mdi/js'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import CardBox from '@/components/CardBox.vue'
import CardBoxModal from '@/components/CardBoxModal.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import FormCheckRadioGroup from '@/components/FormCheckRadioGroup.vue'
import { darkModeKey, useDarkModeStore } from '@/stores/darkMode'

defineProps({ mustVerifyEmail: Boolean, status: String })
const user = computed(() => usePage().props.auth.user)
const showOptions = ref(false)
const profileForm = useForm({ name: user.value.name, email: user.value.email, username: user.value.username })
const passwordForm = useForm({ current_password: '', password: '', password_confirmation: '' })
const deleteForm = useForm({ password: '' })
const isDeleteModalActive = ref(false)

const submitProfile = () => profileForm.patch(route('profile.update'), { preserveScroll: true })
const submitPassword = () => passwordForm.put(route('password.update'), {
  preserveScroll: true,
  onSuccess: () => passwordForm.reset(),
  onError: () => passwordForm.reset('current_password', 'password', 'password_confirmation'),
})
const closeDelete = () => { deleteForm.reset(); deleteForm.clearErrors() }
const submitDelete = () => deleteForm.delete(route('profile.destroy'), { preserveScroll: true })

const darkModeStore = useDarkModeStore()
const savedAppearance = typeof localStorage !== 'undefined' ? localStorage.getItem(darkModeKey) : null
const appearance = ref(savedAppearance === null ? 'system' : savedAppearance === '1' ? 'dark' : 'light')
watch(appearance, value => {
  if (value === 'system') {
    localStorage.removeItem(darkModeKey)
    darkModeStore.set(window.matchMedia('(prefers-color-scheme: dark)').matches)
  } else darkModeStore.set(value === 'dark', true)
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Profile" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccount" title="Profile" main>
        <BaseButton
          :icon="mdiCog"
          label="Options"
          color="whiteDark"
          :active="showOptions"
          :aria-expanded="showOptions"
          aria-controls="profile-options"
          @click="showOptions = !showOptions"
        />
      </SectionTitleLineWithButton>

      <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <CardBox is-form @submit.prevent="submitProfile">
          <FormField label="Name" label-for="profile-name" help="Required. Your name" :error="profileForm.errors.name">
            <FormControl id="profile-name" v-model="profileForm.name" :icon="mdiAccount" name="name" required autocomplete="name" maxlength="255" />
          </FormField>
          
          <FormField label="Username" label-for="profile-username" help="Required. Your username" :error="profileForm.errors.username">
            <FormControl id="profile-username" v-model="profileForm.username" :icon="mdiAccount" name="username" required autocomplete="username" maxlength="255" />
          </FormField>

          <FormField label="E-mail" label-for="profile-email" help="Required. Your e-mail" :error="profileForm.errors.email">
            <FormControl id="profile-email" v-model="profileForm.email" :icon="mdiMail" type="email" name="email" required autocomplete="email" maxlength="255" />
          </FormField>

          <div v-if="mustVerifyEmail && !user.email_verified_at" class="text-sm">
            <p>Your email address is unverified. <Link :href="route('verification.send')" method="post" as="button" class="underline">Click here to resend the verification email.</Link></p>
            <p v-if="status === 'verification-link-sent'" role="status" class="mt-2 text-green-600">A new verification link has been sent to your email address.</p>
          </div>

          <template #footer>
            <BaseButtons>
              <BaseButton color="info" type="submit" label="Submit" :disabled="profileForm.processing" />
              <span v-if="profileForm.recentlySuccessful" role="status" class="text-sm">Saved!</span>
            </BaseButtons>
          </template>
        </CardBox>

        <CardBox is-form @submit.prevent="submitPassword">
          <FormField label="Current password" label-for="current-password" help="Required. Your current password" :error="passwordForm.errors.current_password">
            <FormControl id="current-password" v-model="passwordForm.current_password" :icon="mdiAsterisk" name="current_password" type="password" required autocomplete="current-password" />
          </FormField>
          <BaseDivider />
          <FormField label="New password" label-for="new-password" help="Required. New password" :error="passwordForm.errors.password">
            <FormControl id="new-password" v-model="passwordForm.password" :icon="mdiFormTextboxPassword" name="password" type="password" required autocomplete="new-password" />
          </FormField>
          <FormField label="Confirm password" label-for="confirm-password" help="Required. New password one more time" :error="passwordForm.errors.password_confirmation">
            <FormControl id="confirm-password" v-model="passwordForm.password_confirmation" :icon="mdiFormTextboxPassword" name="password_confirmation" type="password" required autocomplete="new-password" />
          </FormField>

          <template #footer>
            <BaseButtons>
              <BaseButton color="info" type="submit" label="Submit" :disabled="passwordForm.processing" />
              <span v-if="passwordForm.recentlySuccessful" role="status" class="text-sm">Saved!</span>
            </BaseButtons>
          </template>
        </CardBox>
      </div>

      <div id="profile-options" v-show="showOptions">
        <CardBox class="mb-6">
          <FormField label="Dashboard theme">
            <FormCheckRadioGroup v-model="appearance" name="appearance" type="radio" :options="{ system: 'System', light: 'Light', dark: 'Dark' }" />
          </FormField>
        </CardBox>
        <CardBox>
          <BaseButton label="Delete account" color="danger" @click="isDeleteModalActive = true" />
        </CardBox>
      </div>

      <CardBoxModal v-model="isDeleteModalActive" title="Delete your account?" button="danger" button-label="Delete account" has-cancel is-form :is-processing="deleteForm.processing" @confirm="submitDelete" @cancel="closeDelete">
        <p class="mb-6">This permanently deletes your account and its data. Enter your current password to confirm.</p>
        <FormField label="Current password" label-for="delete-password" :error="deleteForm.errors.password">
          <FormControl id="delete-password" v-model="deleteForm.password" :icon="mdiAsterisk" name="password" type="password" autocomplete="current-password" required />
        </FormField>
      </CardBoxModal>
    </SectionMain>
  </LayoutAuthenticated>
</template>
