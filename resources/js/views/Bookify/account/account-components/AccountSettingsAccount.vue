<script>
import avatar1 from '@images/avatars/avatar-1.png';
import axios from 'axios';

export default {
  data() {
    return {
      id: null,
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
      birthplaces: [
        {
          "id": 1,
          "name": "Example 1"
        },
        {
          "id": 2,
          "name": "Example 2"
        },
        {
          "id": 3,
          "name": "Example 3"
        }
      ],
      picture: null,
      refInputEl: null,
      isAccountDeactivated: false,
      isEditMode: false,
    };
  },
  methods: {
    changeAvatar(file) {
      const fileReader = new FileReader();
      const { files } = file.target;
      if (files && files.length) {
        fileReader.readAsDataURL(files[0]);
        fileReader.onload = () => {
          if (typeof fileReader.result === 'string') {
            this.accountData.pedagogy.picture = fileReader.result;
            this.picture = fileReader.result;
          }
        };
      }
    },
    resetAvatar() {
      // this.accountData.pedagogy.picture = this.accountData.pedagogy.picture;
    },
    toggleEditMode() {
      this.isEditMode = !this.isEditMode;
    },
    async saveChanges() {
      this.toggleEditMode();
    },
    async fetchData() {
      await axios.get('/api/user')
        .then(response => {
          console.log(response.data.data)
          this.accountData = response.data.data; // Update accountData with fetched data

          this.picture = import.meta.env.VITE_PUSHER_DOMAIN_NAME + "/storage/app/" + this.accountData.pedagogy.picture
          console.log(this.accountData.pedagogy.person.birthdate)
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });

      await axios.get('/api/birthplace')
        .then(response => {
          this.birthplaces = response.data; // Update accountData with fetched data
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
  },
  created() {
    this.fetchData();
  }
};
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
            :image="picture"
          />
          <!-- Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn
                color="primary"
                @click="refInputEl?.click()"
              >
                <VIcon
                  icon="bx-cloud-upload"
                  class="d-sm-none"
                />
                <span class="d-none d-sm-block">Upload New Photo</span>
              </VBtn>

              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,GIF"
                hidden
                @input="changeAvatar"
              >

              <VBtn
                type="reset"
                color="error"
                variant="tonal"
                @click="resetAvatar"
              >
                <span class="d-none d-sm-block">Reset</span>
                <VIcon
                  icon="bx-refresh"
                  class="d-sm-none"
                />
              </VBtn>
            </div>

            <p class="text-body-3 mb-0">
              Allowed formats: JPG, GIF, PNG.
              <br>
              Maximum size: 10MB
            </p>
          </form>
        </VCardText>
        <VDivider />

        <!-- Edit, Save, and Cancel Buttons -->
        <VCardText v-if="!isEditMode">
          <div class="d-flex gap-4">
            <VBtn color="primary" @click="toggleEditMode">Edit</VBtn>
          </div>
        </VCardText>

        <VCardText>
          <!-- 👉 Form -->
          <VForm class="mt-6">
            <VRow>
              <!-- 👉 First Name -->
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.firstname"
                  placeholder="e.g. John"
                  label="First Name"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Last Name -->
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.lastname"
                  placeholder="e.g. Doe"
                  label="Last Name"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Father Name -->
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.fathername"
                  placeholder="e.g. Michael"
                  label="Father's Name"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Grand Father Name -->
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.pedagogy.person.grandfathername"
                  placeholder="e.g. Smith"
                  label="Grandfather's Name"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Birthdate -->
              <VCol md="6" cols="12">
                <DatePicker
                  :date="accountData.pedagogy.person.birthdate"
                  :readonly="!isEditMode"
                  placeholder="Select your birthdate"
                  label="Birthdate"
                />
              </VCol>

              <!-- 👉 Birthplace -->
              <VCol cols="12" md="6">
                <VSelect
                  v-model="accountData.pedagogy.person.birthplace"
                  label="Birthplace"
                  placeholder="Select your birthplace"
                  :items="birthplaces"
                  :item-title="(item) => `${item.id} - ${item.name}`"
                  :item-value="id"
                  :menu-props="{ maxHeight: 200 }"
                  :readonly="!isEditMode"
                />

              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.pedagogy.email"
                  placeholder="example@mail.com"
                  label="Email"
                  type="email"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Phone1 -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.pedagogy.phone1"
                  label="Phone Number 1"
                  placeholder="+123 456-7890"
                  :readonly="!isEditMode"
                />
              </VCol>

              <!-- 👉 Phone2 -->
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

        <!-- 👉 Edit, Save, and Cancel Buttons -->
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
