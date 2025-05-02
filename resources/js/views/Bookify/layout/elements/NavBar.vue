<template>
  <div>
    <!-- Links visibles pour tous -->
    <NavBarSectionTitle :item="{ heading: 'General' }" />
    <NavBarLink
      :item="{
        title: 'Dashboard',
        icon: 'bx-home',
        to: '/dashboard',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Account Settings',
        icon: 'mdi-account-cog-outline',
        to: '/account-settings',
      }"
    />

    <!-- ADMIN LINKS -->
    <div v-if="userdata || userdata.type === 'admin'">
      <NavBarSectionTitle :item="{ heading: 'Management' }" />

      <NavBarLink :item="{ title: 'Events', icon: 'carbon:event', to: '/events' }" />
      <NavBarLink :item="{ title: 'Categories', icon: 'bx-list-ul', to: '/categories' }" />
      <NavBarLink :item="{ title: 'Organizers', icon: 'mdi-account-tie', to: '/organizers' }" />
      <NavBarLink :item="{ title: 'Bookings', icon: 'mdi-calendar-check', to: '/bookings' }" />
      <NavBarLink :item="{ title: 'Tickets', icon: 'mdi-ticket-confirmation-outline', to: '/tickets' }" />
      <NavBarLink :item="{ title: 'Reviews', icon: 'mdi-star-outline', to: '/reviews' }" />
      <NavBarLink :item="{ title: 'Users', icon: 'mdi-account-multiple-outline', to: '/users' }" />
    </div>

    <!-- CLIENT LINKS -->
    <div v-if="userdata && userdata.type === 'client'">
      <NavBarSectionTitle :item="{ heading: 'User Area' }" />
      <NavBarLink :item="{ title: 'Buy a Book', icon: 'bx-book', to: '/buybooks' }" />
      <NavBarLink :item="{ title: 'My Orders', icon: 'bx-cart', to: '/myorders' }" />
    </div>
  </div>
</template>

<script>
import NavBarLayout from '@/views/Bookify/layout/elements/NavBar/NavBarLayout.vue';
import NavBarLink from '@/views/Bookify/layout/elements/NavBar/NavBarLink.vue';
import NavBarSectionTitle from '@/views/Bookify/layout/elements/NavBar/NavBarSectionTitle.vue';

export default {
  components: { NavBarSectionTitle, NavBarLayout, NavBarLink },
  data() {
    return {
      userdata: null,
    };
  },
  methods: {
    getuserdata() {
      this.userdata = this.$store.state.data.user;
    },
  },
  created() {
    this.getuserdata();
  },
};
</script>

<style scoped>
/* أضف هنا أي تنسيقات إضافية إذا احتجت */
</style>
