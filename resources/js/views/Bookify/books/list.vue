<template lang="">
  <ListForm 
    :attributes="bookAttributes" 
    :elements="bookElements"
    cardtext="List of all books in the bookstore"
    cardtitle="Books"
    :tableLoading="loading"
    nakiraword="Book"
    gword="book"
    exportExcel="export/books"
    :numfields="6"
    @fetchdata="fetchBooks"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      bookAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'title', title: 'Title' },
        { key: 'author.name', title: 'Author' },
        { key: 'isbn', title: 'ISBN' },
        { key: 'publication_date', title: 'Publication Date' },
        { key: 'genre.name', title: 'Genre' },
        { key: 'price', title: 'Price' },
        { key: 'stock_quantity', title: 'Stock' },
      ],
      bookElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchBooks() {
      this.loading = true;
      this.bookElements = [];
      try {
        const response = await axios.get('/api/book');
        this.bookElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchBooks();
  },
};
</script>
