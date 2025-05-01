<script>
import axios from 'axios';

export default {
  data() {
    return {
      isCurrentPasswordVisible: false,
      isNewPasswordVisible: false,
      isConfirmPasswordVisible: false,
      currentPassword: null,
      newPassword: null,
      confirmPassword: null,

      isLoading: false,

      passwordRequirements: [
        'The password must be at least 8 characters long - the longer, the better',
        'At least one lowercase letter',
        'At least one number, symbol, or whitespace character',
      ]
    }
  },
  methods: {
    changePassword() {
      this.isLoading = true;
      const data = {
        current_password: this.currentPassword,
        new_password: this.newPassword,
        new_password_confirmation: this.confirmPassword, // Should be identical to 'new_password'
      };

      axios.post('/api/change-password', data)
        .then(response => {
          // Handle the success response
          console.log(response.data.message);
          this.$refs.passwordForm.reset();
          this.$refs.passwordForm.resetValidation();
          this.isLoading = false;
        })
        .catch(error => {
          // Handle any errors, such as validation errors or authentication failures
          console.error(error.response.data.message);
        });
    }
  }
}
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Change Password" :loading="isLoading">
        <VForm ref="passwordForm">
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow>
              <VCol
                cols="12"
                md="12"
              >
                <!-- 👉 current password -->
                <VTextField
                  v-model="currentPassword"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isCurrentPasswordVisible ? 'bx-hide' : 'bx-show'"
                  label="Current Password"
                  placeholder="············"
                  @click:append-inner="isCurrentPasswordVisible = !isCurrentPasswordVisible"
                />
              </VCol>
            </VRow>

            <!-- 👉 New Password -->
            <VRow>
              <VCol
                cols="12"
                md="6"
              >
                <!-- 👉 new password -->
                <VTextField
                  v-model="newPassword"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isNewPasswordVisible ? 'bx-hide' : 'bx-show'"
                  label="New Password"
                  placeholder="············"
                  @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible"
                />
              </VCol>

              <VCol
                cols="12"
                md="6"
              >
                <!-- 👉 confirm password -->
                <VTextField
                  v-model="confirmPassword"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'"
                  label="Confirm New Password"
                  placeholder="············"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
                />
              </VCol>
            </VRow>
          </VCardText>

          <!-- 👉 Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium mt-2">
              Accepted password requirements:
            </p>

            <ul class="d-flex flex-column gap-y-3">
              <li
                v-for="item in passwordRequirements"
                :key="item"
                class="d-flex"
              >
                <div>
                  <VIcon
                    size="7"
                    icon="bxs-circle"
                    class="me-3"
                  />
                </div>
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>

          <!-- 👉 Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4">
            <VBtn @click="changePassword">Save Changes</VBtn>

            <VBtn
              type="reset"
              color="secondary"
              variant="tonal"
            >
              Reset
            </VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
    <!-- !SECTION -->
  </VRow>
</template>
