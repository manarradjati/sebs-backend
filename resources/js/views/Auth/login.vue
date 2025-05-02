 <script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import logo_cutted from '@images/logo-cutted.png'

// 🖼️ Background images
const backgroundImages = [
  "https://i.pinimg.com/736x/c8/b0/7e/c8b07e380215edaaa1903769586a61dc.jpg",
  "https://png.pngtree.com/thumb_back/fh260/background/20230611/pngtree-an-empty-bookshop-stacked-with-books-image_2924924.jpg",
  "https://wallpapercave.com/wp/wp10175933.jpg",
]
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

// 🔐 Auth + Routing
const store = useStore()
const router = useRouter()

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const login = async () => {
  const { email, password, remember } = form.value
  try {
    await store.dispatch('login', form.value)
      .then(response => {
        console.log('Logged in successfully')
        router.push('/dashboard') // ✅ التوجيه بعد تسجيل الدخول
      })
      .catch(error => {
        console.error('Login error:', error)
      })
  } catch (error) {
    console.error('Login error:', error)
  }
}

const isPasswordVisible = ref(false)
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
      <VCard class="auth-card pt-2" max-width="448">
        <VCardItem class="justify-center">
          <template #prepend>
            <img :src="logo_cutted" width="30" height="50" />
          </template>
          <VCardTitle class="text-2xl font-weight-bold">Bookify</VCardTitle>
        </VCardItem>

        <VDivider />

        <VCardItem class="justify-center">
          <VCardTitle>👋🏻 Hello in the Books Store Platform</VCardTitle>
        </VCardItem>

        <VCardText>
          <VForm @submit.prevent="login">
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="form.email"
                  placeholder="yourname@example.com"
                  label="Email"
                  type="email"
                  autofocus
                />
              </VCol>

              <VCol cols="12">
                <VTextField
                  v-model="form.password"
                  label="Password"
                  placeholder="············"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <div class="d-flex align-center justify-space-between flex-wrap mt-1 mb-4">
                  <VCheckbox v-model="form.remember" label="Remember me" />
                  <RouterLink
                    class="text-primary ms-2 mb-1 mx-4"
                    to="javascript:void(0)"
                    aria-disabled="true"
                  >
                    Forgot password?
                  </RouterLink>
                </div>

                <VBtn block type="submit">Log in</VBtn>
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
