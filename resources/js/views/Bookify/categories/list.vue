<template lang="">
  <ListForm 
    :attributes="categoryAttributes" 
    :elements="categoryElements"
    cardtext="List of all categories in the system"
    cardtitle="Categories"
    :tableLoading="loading"
    nakiraword="Category"
    gword="categories"
    exportExcel="export/categories"
    :numfields="3"
    @fetchdata="fetchCategories"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      categoryAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'name', title: 'Name' },
        { key: 'description', title: 'Description' },
      ],
      categoryElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchCategories() {
      this.loading = true;
      this.categoryElements = [];
      try {
        const response = await axios.get('/api/categories');
        this.categoryElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchCategories();
  },
};
</script>
