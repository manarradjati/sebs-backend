<script setup>
const recentDevices = ref([
  {
    type: 'New for you',
    email: true,
    browser: true,
    app: true,
  },
  {
    type: 'Account activity',
    email: true,
    browser: true,
    app: true,
  },
  {
    type: 'New browser used for login',
    email: true,
    browser: true,
    app: false,
  },
  {
    type: 'New device linked',
    email: true,
    browser: false,
    app: false,
  },
]);

const selectedNotification = ref('Only when I am connected to the internet');
</script>

<template>
  <VCard title="Account Actions">
    <VCardText>
      We need permission from your browser to display notifications.
      <a href="javascript:void(0)">Request Permission</a>
    </VCardText>

    <VTable class="text-no-wrap">
      <thead>
        <tr>
          <th scope="col">
            Type
          </th>
          <th scope="col">
            Email
          </th>
          <th scope="col">
            Browser
          </th>
          <th scope="col">
            App
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="device in recentDevices" :key="device.type">
          <td>
            {{ device.type }}
          </td>
          <td>
            <VCheckbox v-model="device.email" />
          </td>
          <td>
            <VCheckbox v-model="device.browser" />
          </td>
          <td>
            <VCheckbox v-model="device.app" />
          </td>
        </tr>
      </tbody>
    </VTable>
    <VDivider />

    <VCardText>
      <VForm @submit.prevent="() => {}">
        <p class="text-base font-weight-medium">
          When should we send you notifications?
        </p>

        <VRow>
          <VCol cols="12" sm="6">
            <VSelect
              v-model="selectedNotification"
              mandatory
              :items="['Only when I am connected to the internet', 'Anytime']"
            />
          </VCol>
        </VRow>

        <div class="d-flex flex-wrap gap-4 mt-4">
          <VBtn type="submit">
            Save Changes
          </VBtn>
          <VBtn color="secondary" variant="tonal" type="reset">
            Reset
          </VBtn>
        </div>
      </VForm>
    </VCardText>
  </VCard>
</template>

<style lang="scss" scoped>
.v-table {
  th {
    text-align: start !important;
  }
}
</style>
