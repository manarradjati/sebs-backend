<template>
  <div class="toast-container">
    <vue-toast></vue-toast>
  </div>
</template>

<script>
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  name: 'Toast',
  components: {
    VueToast,
  },
};
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
}
</style>
