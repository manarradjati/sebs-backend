<script>
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'

import avatar5 from '@images/avatars/avatar-5.png'
import avatar6 from '@images/avatars/avatar-6.png'
import avatar7 from '@images/avatars/avatar-7.png'

import pages1 from '@images/pages/1.png'
import background from '@images/backgrounds/bg2.jpg'

export default {
  data() {
    return {
      avatars: {
        avatar1,
        avatar2,
        avatar3,
        avatar4,
        avatar5,
        avatar6,
        avatar7,
      },
      background: background,
      pages1: pages1,
    };
  },
};
</script>

<template>
  <VRow>
    <VCol>
      <VCard>
        <div class="custom-vimg-container">
          <img :src="background" class="custom-vimg" />
        </div>

        <VCardText class="position-relative">
          <!-- User Avatar -->
          <div class="text-no-wrap">
            <VAvatar
              size="128"
              class="avatar-center"
              :image="avatars.avatar1"
            />
          </div>
          
          <!-- Title, Subtitle & Action Button -->
          <div class="d-flex justify-space-between flex-wrap pt-10">
            <div class="me-2 mb-2">
              <VCardTitle class="pa-0" style="font-size: 2em;">
                John Doe
              </VCardTitle>
              <VCardSubtitle class="pa-0" style="font-size: 1.1em;">
                Student
              </VCardSubtitle>
            </div>

            <IconBtn>
              <VIcon icon="bx-dots-vertical" />

              <VMenu
                activator="parent"
              >
                <VList>
                  <VListItem>
                    <IconBtn @click="viewAction(item)" :loading="downloadisLoading">
                      <VIcon icon="mdi-eye" />
                      <VTooltip
                        activator="parent"
                        scroll-strategy="close" 
                      >
                        View Personal Information
                      </VTooltip>
                    </IconBtn>
                  </VListItem>

                  <VListItem>
                    <IconBtn @click="updateAction(item)" :loading="downloadisLoading">
                      <VIcon icon="mdi-pencil" />
                      <VTooltip
                        activator="parent"
                        scroll-strategy="close" 
                      >
                        Edit Account Information
                      </VTooltip>
                    </IconBtn>
                  </VListItem>

                  <VListItem>
                    <IconBtn @click="deleteAction(item)" :loading="downloadisLoading">
                      <VIcon icon="mdi-delete" />
                      <VTooltip
                        activator="parent"
                        scroll-strategy="close" 
                      >
                        Delete Account
                      </VTooltip>
                    </IconBtn>
                  </VListItem>
                </VList>
              </VMenu>

              <VTooltip
                activator="parent"
                scroll-strategy="close" 
              >
                Details
              </VTooltip>
            </IconBtn>
          </div>

          <!-- Mutual Friends -->
          <div class="d-flex justify-space-between align-center mt-4">
            <span class="font-weight-medium">Teachers who taught the student:</span>

            <div class="v-avatar-group" style="display: block;">
              <span class="font-weight-medium">Some notable teachers:</span>
              <br>
              <VAvatar
                v-for="avatar in avatars"
                :key="avatar"
                :image="avatar"
                size="40"
              />
            </div>
          </div>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss" scoped>
.v-table {
  th {
    text-align: start !important;
  }
}
.avatar-center {
  position: absolute;
  border: 3px solid rgb(var(--v-theme-surface));
  inset-block-start: -4rem;
  inset-inline-start: 1rem;
}

.custom-vimg-container {
  width: 100%;
  height: 10rem; /* Adjust the height as needed */
  overflow: hidden;
}

.custom-vimg {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
