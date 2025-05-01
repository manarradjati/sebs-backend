<template lang="">
  <ListForm 
    :attributes="genreAttributes" 
    :elements="genreElements"
    cardtext="List of all genres in the bookstore"
    cardtitle="Genres"
    :tableLoading="loading"
    nakiraword="Genre"
    gword="genre"
    exportExcel="export/genres"
    :numfields="2"
    @fetchdata="fetchGenres"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      genreAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'name', title: 'Genre Name' },
      ],
      genreElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchGenres() {
      this.loading = true;
      this.genreElements = [];
      try {
        const response = await axios.get('/api/genre');
        this.genreElements = response.data.data;
        this.loading = false;
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchGenres();
  },
};
</script>
