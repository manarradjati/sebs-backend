<template>
  <div class="d-flex align-center justify-center pa-5 mt-3">
    <div class="background-overlay" />
    <AccountProfile></AccountProfile>
  </div>
</template>
<script>
import AccountProfile from '../g-pages/account-settings/AccountProfile.vue';

export default {
  data(){
    return{
      username:this.$route.params.username,
    }
  },
  components:{AccountProfile}
  
}
</script>
<style lang="scss">
  .background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("@images/backgrounds/profile-background.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 0.5; /* Adjust the opacity value as needed */
  }
</style>
