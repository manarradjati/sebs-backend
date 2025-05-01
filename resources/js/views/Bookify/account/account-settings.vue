<script setup>
import { useRoute } from 'vue-router'
import AccountSettingsAccount from '@/views/Bookify/account/account-components/AccountSettingsAccount.vue'
import AccountSettingsSecurity from '@/views/Bookify/account/account-components/AccountSettingsSecurity.vue'
import AccountProfile from '@/views/Bookify/account/account-components/AccountProfile.vue'

import AccountActions from '@/views/Bookify/account/account-components/AccountActions.vue'
import AccountSettingsNotification from '@/views/Bookify/account/account-components/AccountSettingsNotification.vue'


const route = useRoute()
const activeTab = ref(route.params.tab)

// tabs
const tabs = [
  {
    title: 'Account',
    icon: 'bx-cog',
    tab: 'account',
  },
  {
    title: 'Security',
    icon: 'bx-lock-open',
    tab: 'security',
  },
  {
    title: 'Profile',
    icon: 'bx-user',
    tab: 'profile',
    disabled: true,
  },
  {
    title: 'Notifications',
    icon: 'bx-bell',
    tab: 'notification',
  },
  // {
  //   title: 'actions',
  //   icon: 'bx-caret-right-circle',
  //   tab: 'actions',
  // },

  
]
</script>

<template>
  <div>
    <VTabs
      v-model="activeTab"
      show-arrows
    >
      <VTab
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
        :disabled="item.disabled"
      >
        <VIcon
          size="20"
          start
          :icon="item.icon"
        />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />

    <VWindow
      v-model="activeTab"
      class="mt-5 disable-tab-transition"
    >
      <!-- Account -->
      <VWindowItem value="account">
        <AccountSettingsAccount />
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <AccountSettingsSecurity />
      </VWindowItem>

      <!-- Profile -->
      <VWindowItem value="profile">
        <AccountProfile />
      </VWindowItem>

      <!-- Actions -->
      <!--
      <VWindowItem value="actions">
        <AccountActions />
      </VWindowItem>
      -->

      <!-- Notification -->
      
      <VWindowItem value="notification">
        <AccountSettingsNotification />
      </VWindowItem>
      
    </VWindow>
  </div>
</template>
