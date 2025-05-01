<template lang="">
  <div>
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

    <div v-if="userdata && userdata.type === 'admin'">
      <!-- 👉 Quick Access -->
      <NavBarSectionTitle
        :item="{
          heading: 'Pages',
        }"
      />

      <NavBarLink
        :item="{
          title: 'Books',
          icon: 'bx-book',
          to: '/books',
        }"
      />

      <NavBarLink
        :item="{
          title: 'Authors',
          icon: 'bx-user',
          to: '/authors',
        }"
      />

      <NavBarLink
        :item="{
          title: 'Genres',
          icon: 'bx-bookmark',
          to: '/genres',
        }"
      />

      <NavBarLink
        :item="{
          title: 'Orders',
          icon: 'bx-cart',
          to: '/orders',
        }"
      />
    </div>

    <div v-if="userdata && userdata.type === 'client'">
      <!-- 👉 Quick Access -->
      <NavBarSectionTitle
        :item="{
          heading: 'Pages',
        }"
      />

      <NavBarLink
        :item="{
          title: 'Buy a Book',
          icon: 'bx-book',
          to: '/buybooks',
        }"
      />

      <NavBarLink
        :item="{
          title: 'My Orders',
          icon: 'bx-cart',
          to: '/myorders',
        }"
      />
    </div>

    <!-- 👉 Auth pages -->
    <!-- 
      <NavBarSectionTitle
      :item="{
      heading: 'Pages',
      }"
      />
      
      <NavBarLink
        :item="{
          title: 'Login',
          icon: 'bx-log-in',
          to: '/login',
        }"
      />
      <NavBarLink
        :item="{
          title: 'Register',
          icon: 'bx-user-plus',
          to: '/register',
        }"
      />
      <NavBarLink
        :item="{
          title: 'Error',
          icon: 'bx-info-circle',
          to: '/no-existence',
        }"
      />

    -->

    <!-- 👉 Template Interface
    <NavBarSectionTitle
      :item="{
        heading: 'Interface Temp',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Dashboard',
        icon: 'bx-home',
        to: '/dashboard-example',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Typography',
        icon: 'mdi-alpha-t-box-outline',
        to: '/typography',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Icons',
        icon: 'bx-show',
        to: '/icons',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Cards',
        icon: 'bx-credit-card',
        to: '/cards',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Tables',
        icon: 'bx-table',
        to: '/tables',
      }"
    />
    <NavBarLink
      :item="{
        title: 'Form Layouts',
        icon: 'mdi-form-select',
        to: '/form-layouts',
      }"
    /> -->
  </div>
</template>
<script>
import NavBarLayout from '@/views/Bookify/layout/elements/NavBar/NavBarLayout.vue';
import NavBarLink from '@/views/Bookify/layout/elements/NavBar/NavBarLink.vue';
import NavBarSectionTitle from '@/views/Bookify/layout/elements/NavBar/NavBarSectionTitle.vue';

export default {
  components:{NavBarSectionTitle,NavBarLayout,NavBarLink},
  data(){
    return{
      userdata: null,
    }
  },
  methods:{
    getuserdata(){
      this.userdata = this.$store.state.data.user;
    }
  },
  created(){
    this.getuserdata();
  }
}
</script>

<style lang="">
  
</style>
