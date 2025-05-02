<template lang="">
  <ListForm 
    :attributes="bookingAttributes" 
    :elements="bookingElements"
    cardtext="List of all bookings"
    cardtitle="Bookings"
    :tableLoading="loading"
    nakiraword="Booking"
    gword="bookings"
    exportExcel="export/bookings"
    :numfields="5"
    @fetchdata="fetchBookings"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      bookingAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'count', title: 'Count' },
        { key: 'total_price', title: 'Total Price' },
        { key: 'status', title: 'Status' },
        { key: 'user.name', title: 'User' },
        { key: 'event.name', title: 'Event' }, // assuming event has a 'name'
      ],
      bookingElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchBookings() {
      this.loading = true;
      this.bookingElements = [];
      try {
        const response = await axios.get('/api/bookings');
        this.bookingElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchBookings();
  },
};
</script>
