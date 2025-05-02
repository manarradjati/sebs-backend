 <script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({
      to: null,
      href: null,
      icon: '',
      title: '',
      disable: false,
    }),
  },
});
</script>

<template>
  <li class="nav-link" :class="{ disabled: item.disable }">
    <Component
      :is="item.to ? 'RouterLink' : 'a'"
      :to="item.to"
      :href="item.href"
    >
      <VIcon :icon="item.icon" class="nav-item-icon" />
      <!-- 👉 Title -->
      <span class="nav-item-title">
        {{ item.title }}
      </span>
    </Component>
  </li>
</template>

<style lang="scss">
.layout-vertical-nav {
  .nav-link a {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 10px; /* إضافة مسافات للرابط */
    transition: background-color 0.3s ease;
  }

  .nav-link a:hover {
    background-color: #f0f0f0; /* إضافة تأثير عند التمرير فوق الرابط */
  }

  .nav-link.disabled a {
    cursor: not-allowed;
    pointer-events: none;
    color: #ccc; /* تغيير اللون عند التعطيل */
  }

  .nav-item-icon {
    margin-right: 10px; /* إضافة مسافة بين الأيقونة والعنوان */
  }

  .nav-item-title {
    overflow: hidden;
    margin-inline-end: auto;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}
</style>
