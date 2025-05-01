<template lang="">
  <div class="d-flex h-100 align-center">
    <!-- 👉 Vertical nav toggle in overlay mode -->
    <IconBtn
      class="ms-n3 d-lg-none"
      @click="function_(true)"
    >
      <VIcon icon="bx-menu" />
    </IconBtn>

    <!-- 👉 Search -->
    <TopBarSearch />

    <VSpacer />

    <TopBarNotifications :notifications="arrayNotifs" />

    <TopBarThemeSwitcher class="me-2" />

    <TopBarUserProfile />
  </div>
</template>

<script>

import TopBarNotifications from '@/views/Bookify/layout/elements/TopBar/TopBarNotifications.vue'
import TopBarThemeSwitcher from '@/views/Bookify/layout/elements/TopBar/TopBarThemeSwitcher.vue'
import TopBarUserProfile from '@/views/Bookify/layout/elements/TopBar/TopBarUserProfile.vue'
import TopBarSearch from '@/views/Bookify/layout/elements/TopBar/TopBarSearch.vue'

export default {
  data() {
    return {

    }
  },
  components:{TopBarNotifications,TopBarUserProfile,TopBarThemeSwitcher,TopBarSearch},
  props:{
    function_:{
      type:Function,
      required:true
    }
  }
  
}
</script>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
