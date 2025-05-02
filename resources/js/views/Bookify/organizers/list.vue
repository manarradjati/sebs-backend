<template lang="">
  <ListForm 
    :attributes="organizerAttributes" 
    :elements="organizerElements"
    cardtext="List of all organizers in the system"
    cardtitle="Organizers"
    :tableLoading="loading"
    nakiraword="Organizer"
    gword="organizers"
    exportExcel="export/organizers"
    :numfields="4"
    @fetchdata="fetchOrganizers"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      organizerAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'company_name', title: 'Company Name' },
        { key: 'bio', title: 'Bio' },
        { key: 'website', title: 'Website' },
        { key: 'user.name', title: 'User Name' }, // Assuming eager-loaded relation
      ],
      organizerElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchOrganizers() {
      this.loading = true;
      this.organizerElements = [];
      try {
        const response = await axios.get('/api/organizers');
        this.organizerElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchOrganizers();
  },
};
</script>
