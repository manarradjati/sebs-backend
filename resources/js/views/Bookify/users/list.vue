<template lang="">
  <ListForm 
    :attributes="userAttributes" 
    :elements="userElements"
    cardtext="List of all users in the system"
    cardtitle="Users"
    :tableLoading="loading"
    nakiraword="User"
    gword="users"
    exportExcel="export/users"
    :numfields="6"
    @fetchdata="fetchUsers"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      userAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'name', title: 'Name' },
        { key: 'username', title: 'Username' },
        { key: 'email', title: 'Email' },
        { key: 'phone', title: 'Phone' },
        { key: 'age', title: 'Age' },
        { key: 'address', title: 'Address' },
        { key: 'is_banned', title: 'Banned Status' },
      ],
      userElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchUsers() {
      this.loading = true;
      this.userElements = [];
      try {
        const response = await axios.get('/api/users');
        this.userElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchUsers();
  },
};
</script>
