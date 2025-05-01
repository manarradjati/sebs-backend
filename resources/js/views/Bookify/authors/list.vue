<template lang="">
  <ListForm 
    :attributes="authorAttributes" 
    :elements="authorElements"
    cardtext="List of all authors in the bookstore"
    cardtitle="Authors"
    :tableLoading="loading"
    nakiraword="Author"
    gword="author"
    exportExcel="export/author"
    :numfields="3"
    @fetchdata="fetchAuthors"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      authorAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'name', title: 'Name' },
        { key: 'biography', title: 'Biography' },
      ],
      authorElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchAuthors() {
      this.loading = true;
      this.authorElements = [];
      try {
        const response = await axios.get('/api/author');
        this.authorElements = response.data.data;
        this.loading = false;
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchAuthors();
  },
};
</script>
