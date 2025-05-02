 <script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({
      heading: '', 
    }),
  },
});
</script>

<template>
  <li class="nav-section-title">
    <div class="title-wrapper">
      <!-- عرض العنوان مع التعامل مع الحالات الخاصة مثل وجود HTML -->
      <span class="title-text" v-text="item.heading" />
    </div>
  </li>
</template>

<style lang="scss">
.nav-section-title {
  margin: 15px 0;
  padding: 5px 0;
  font-weight: bold; 
}

.title-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.title-text {
  font-size: 16px;
  color: #333; 
  text-transform: uppercase; 
}
</style>
