<script>
import avatar1 from '@images/avatars/avatar-1.png'
import axios from 'axios'

export default {
  data() {
    return {
      id: null,
      avatar1:avatar1,
      lang: 'en',
      accountData: {
        id: null,
        pedagogy: null,
        email: "",
        pedagogy: {
          id: null,
          person_id_: null,
          picture: "",
          phone1: null,
          phone2: null,
          email: "",
          person: {
            id: null,
            firstname: "",
            lastname: "",
            fathername: "",
            grandfathername: "",
            birthdate: "",
            birthplace: {
              id: null,
              name: ""
            },
            clan: {
              id: null,
              name: ""
            },
            status: {
              id: null,
              name: ""
            }
          }
        }
      },
      birthplaces: [],
      picture: null,
      originalPicture: null,
      isAccountDeactivated: false,
      isEditMode: false,
    };
  },
  methods: {
    changeAvatar(event) {
      const files = event.target.files
      const fileReader = new FileReader()

      if (files && files.length) {
        fileReader.readAsDataURL(files[0])
        fileReader.onload = () => {
          if (typeof fileReader.result === 'string') {
            this.accountData.pedagogy.picture = fileReader.result
            this.picture = fileReader.result
          }
        }
      }
    },
    resetAvatar() {
      // إعادة الصورة الأصلية التي تم تحميلها من الخادم
      this.picture = this.originalPicture
      this.accountData.pedagogy.picture = this.originalPicture
    },
    toggleEditMode() {
      this.isEditMode = !this.isEditMode
    },
    async saveChanges() {
      this.toggleEditMode()
      // من الأفضل هنا إرسال البيانات إلى الخادم لاحقاً
    },
    async fetchData() {
      try {
        const userResponse = await axios.get('/api/user')
        const userData = userResponse.data.data
        this.accountData = userData

        const fullImagePath = import.meta.env.VITE_PUSHER_DOMAIN_NAME + "/storage/app/" + this.accountData.pedagogy.picture
        this.picture = fullImagePath
        this.originalPicture = fullImagePath
      } catch (error) {
        console.error('Error fetching user data:', error)
      }

      try {
        const bpResponse = await axios.get('/api/birthplace')
        this.birthplaces = bpResponse.data
      } catch (error) {
        console.error('Error fetching birthplaces:', error)
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
      <VCard title="Personal Details">
        <VCardText class="d-flex">
          <!-- Avatar -->
          <VAvatar
            rounded="lg"
            size="100"
            class="me-6"
            :image="avatar1"
          />
          <!-- Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn
                color="primary"
                @click="$refs.refInputEl.click()"
              >
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
              >

              <VBtn
                type="reset"
                color="error"
                variant="tonal"
                @click="resetAvatar"
              >
                <span class="d-none d-sm-block">Reset</span>
                <VIcon icon="bx-refresh" class="d-sm-none" />
              </VBtn>
            </div>

            <p class="text-body-3 mb-0">
              Allowed formats: JPG, GIF, PNG.<br>
              Maximum size: 10MB
            </p>
          </form>
        </VCardText>

        <VDivider />

        <!-- <VCardText v-if="!isEditMode">
          <div class="d-flex gap-4">
            <VBtn color="primary" @click="toggleEditMode">Edit</VBtn>
          </div>
        </VCardText> -->

        <VCardText>
          <VForm class="mt-6">
            <VRow>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.firstname"
                  placeholder="e.g. John"
                  label="First Name"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.lastname"
                  placeholder="e.g. Doe"
                  label="Last Name"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.fathername"
                  placeholder="e.g. Michael"
                  label="Father's Name"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.grandfathername"
                  placeholder="e.g. Smith"
                  label="Grandfather's Name"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol md="6" cols="12">
                <DatePicker
                  :date="accountData.pedagogy.person.birthdate"
                  :readonly="!isEditMode"
                  placeholder="Select your birthdate"
                  label="Birthdate"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VSelect
                  v-model="accountData.pedagogy.person.birthplace"
                  label="Birthplace"
                  placeholder="Select your birthplace"
                  :items="birthplaces"
                  :item-title="(item) => `${item.id} - ${item.name}`"
                  item-value="id"
                  :menu-props="{ maxHeight: 200 }"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.pedagogy.email"
                  placeholder="example@mail.com"
                  label="Email"
                  type="email"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.pedagogy.phone1"
                  label="Phone Number 1"
                  placeholder="+123 456-7890"
                  :readonly="!isEditMode"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.pedagogy.phone2"
                  label="Phone Number 2"
                  placeholder="+123 456-7890"
                  :readonly="!isEditMode"
                />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>

        <VCardText v-if="isEditMode">
          <div class="d-flex gap-4">
            <VBtn color="success" @click="saveChanges">Save</VBtn>
            <VBtn color="error" @click="toggleEditMode">Cancel</VBtn>
          </div>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
