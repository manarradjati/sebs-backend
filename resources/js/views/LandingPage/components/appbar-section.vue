<template>
     <v-app-bar app color="indigo" dark>
          <v-toolbar-title> Event_Booking</v-toolbar-title>
          <v-spacer />
          <v-btn color="secondary" @click="navigateToLogin">Login</v-btn>
     </v-app-bar>
</template>

<script>
export default {
     methods: {
          navigateToLogin() {
               this.$router.push({ name: 'Login' });
          },
     },
};
</script>   