<script>
import avatar1 from '@images/avatars/avatar-1.png'
import axios from 'axios'

export default {
  data() {
    return {
      avatar1: avatar1,
      accountData: {
        id: null,
        name: '',
        email: '',
        username: '',
        age: null,
        phone: '',
        address: '',
        is_banned: false,
        avatar: '', // if you support custom profile images
      },
      picture: null,
      originalPicture: null,
      isEditMode: false,
    }
  },
  methods: {
    changeAvatar(event) {
      const files = event.target.files
      const fileReader = new FileReader()

      if (files && files.length) {
        fileReader.readAsDataURL(files[0])
        fileReader.onload = () => {
          if (typeof fileReader.result === 'string') {
            this.picture = fileReader.result
          }
        }
      }
    },
    resetAvatar() {
      this.picture = this.originalPicture
    },
    toggleEditMode() {
      this.isEditMode = !this.isEditMode
    },
    async saveChanges() {
      try {
        await axios.put('/api/user/update', {
          ...this.accountData,
          avatar: this.picture,
        })
        this.toggleEditMode()
      } catch (error) {
        console.error('Error saving user data:', error)
      }
    },
    async fetchData() {
      try {
        const response = await axios.get('/api/user')
        this.accountData = response.data.user

        if (this.accountData.avatar) {
          const fullImagePath = import.meta.env.VITE_PUSHER_DOMAIN_NAME + "/storage/app/" + this.accountData.avatar
          this.picture = fullImagePath
          this.originalPicture = fullImagePath
        }
      } catch (error) {
        console.error('Error fetching user data:', error)
      }
    }
  },
  created() {
    this.fetchData()
  },
}
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="User Profile">
        <VCardText class="d-flex">
          <VAvatar
            rounded="lg"
            size="100"
            class="me-6"
            :image="picture || avatar1"
          />
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="$refs.refInputEl.click()">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Upload New Photo</span>
              </VBtn>

              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,.gif"
                hidden
                @change="changeAvatar"
              />

              <VBtn type="reset" color="error" variant="tonal" @click="resetAvatar">
                <span class="d-none d-sm-block">Reset</span>
                <VIcon icon="bx-refresh" class="d-sm-none" />
              </VBtn>
            </div>

            <p class="text-body-3 mb-0">
              Allowed formats: JPG, GIF, PNG.<br />
              Maximum size: 10MB
            </p>
          </form>
        </VCardText>

        <VDivider />

        <VCardText>
          <VForm class="mt-6">
            <VRow>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.name"
                  label="Full Name"
                  placeholder="e.g. Redouane"
                  :readonly="!isEditMode"
                />
              </VCol>

              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.username"
                  label="Username"
                  placeholder="e.g. redouane.dev"
                  :readonly="!isEditMode"
                />
              </VCol>

              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.email"
                  label="Email"
                  type="email"
                  placeholder="example@mail.com"
                  :readonly="!isEditMode"
                />
              </VCol>

              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.phone"
                  label="Phone"
                  placeholder="+123456789"
                  :readonly="!isEditMode"
                />
              </VCol>

              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.age"
                  label="Age"
                  type="number"
                  placeholder="e.g. 30"
                  :readonly="!isEditMode"
                />
              </VCol>

              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.address"
                  label="Address"
                  placeholder="e.g. 123 Developer St."
                  :readonly="!isEditMode"
                />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>

        <!-- <VCardText>
          <div class="d-flex gap-4">
            <VBtn
              v-if="!isEditMode"
              color="primary"
              @click="toggleEditMode"
            >Edit</VBtn>

            <template v-if="isEditMode">
              <VBtn color="success" @click="saveChanges">Save</VBtn>
              <VBtn color="error" @click="toggleEditMode">Cancel</VBtn>
            </template>
          </div>
        </VCardText> -->
      </VCard>
    </VCol>
  </VRow>
</template>
