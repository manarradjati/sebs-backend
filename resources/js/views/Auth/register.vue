<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

import logo_cutted from '@images/logo-cutted.png'
import bg1 from '@images/backgrounds/bg1.webp'
import bg2 from '@images/backgrounds/bg2.jpg'
import bg3 from '@images/backgrounds/bg3.jpg'
import bg4 from '@images/backgrounds/bg4.jpg'
import AuthProvider from '@/views/g-pages/authentication/AuthProvider.vue'

// Background image logic
const backgroundImages = [bg1, bg2, bg3, bg4]
const currentBackgroundIndex = ref(0)
const transitionDuration = 5000

const changeBackground = () => {
  currentBackgroundIndex.value = (currentBackgroundIndex.value + 1) % backgroundImages.length
}

let intervalId = null
onMounted(() => {
  intervalId = setInterval(changeBackground, transitionDuration)
})
onUnmounted(() => {
  clearInterval(intervalId)
})

// Form and auth
const store = useStore()
const router = useRouter()

const form = ref({
  name: '',
  username: '',
  email: '',
  password: '',
  address: '',
  age: null,
  phone: '',
  privacyPolicies: false,
})

const isPasswordVisible = ref(false)

const register = async () => {
  try {
    await store.dispatch('register', form.value)
    console.log('Registered successfully')
    router.push('/dashboard')
  } catch (error) {
    console.error('Registration error:', error)
  }
}
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <transition name="fade">
      <div
        class="background-overlay"
        :key="currentBackgroundIndex"
        :style="{ backgroundImage: `url(${backgroundImages[currentBackgroundIndex]})` }"
      />
    </transition>

    <div class="content-wrapper">
      <VCard class="auth-card pt-2" max-width="800">
        <VCardItem class="justify-center">
          <template #prepend>
            <img :src="logo_cutted" width="30" height="50" />
          </template>
          <VCardTitle class="text-2xl font-weight-bold"> Bkevent</VCardTitle>
        </VCardItem>

        <VDivider />

        <VCardItem class="justify-center">
          <VCardTitle>🚀 Register a new account</VCardTitle>
        </VCardItem>

        <VCardText>
          <VForm @submit.prevent="register">
            <VRow>
              <VCol cols="6">
                <VTextField
                  v-model="form.name"
                  label="Full Name"
                  placeholder="John Doe"
                  autofocus
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.username"
                  label="Username"
                  placeholder="johndoe"
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.email"
                  label="Email"
                  placeholder="yourname@example.com"
                  type="email"
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.password"
                  label="Password"
                  placeholder="············"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.address"
                  label="Address"
                  placeholder="123 Main St"
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.age"
                  label="Age"
                  type="number"
                  placeholder="25"
                />
              </VCol>

              <VCol cols="6">
                <VTextField
                  v-model="form.phone"
                  label="Phone"
                  type="tel"
                  placeholder="+1 555-123-4567"
                />
              </VCol>

              <VCol cols="12">
                <div class="d-flex align-center mt-1 mb-4">
                  <VCheckbox id="privacy-policy" v-model="form.privacyPolicies" />
                  <VLabel for="privacy-policy" style="opacity: 1;">
                    <span class="me-1">I agree to</span>
                    <a href="javascript:void(0)" class="text-primary">privacy policy & terms</a>
                  </VLabel>
                </div>

                <VBtn block type="submit">Sign up</VBtn>
              </VCol>

              <VCol cols="12" class="text-center text-base">
                <span>Already have an account?</span>
                <RouterLink class="text-primary ms-2" to="/login">Sign in instead</RouterLink>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>


<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";

.auth-wrapper {
  position: relative;
}

.background-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  opacity: 0.5;
}

.content-wrapper {
  position: relative;
  z-index: 1;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
