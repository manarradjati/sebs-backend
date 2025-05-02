<template lang="">
  <ListForm 
    :attributes="reviewAttributes" 
    :elements="reviewElements"
    cardtext="List of all reviews"
    cardtitle="Reviews"
    :tableLoading="loading"
    nakiraword="Review"
    gword="reviews"
    exportExcel="export/reviews"
    :numfields="3"
    @fetchdata="fetchReviews"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      reviewAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'rating', title: 'Rating' },
        { key: 'review', title: 'Review' },
        { key: 'booking.id', title: 'Booking ID' },
      ],
      reviewElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchReviews() {
      this.loading = true;
      this.reviewElements = [];
      try {
        const response = await axios.get('/api/reviews');
        this.reviewElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchReviews();
  },
};
</script>
