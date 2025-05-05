<template lang="html">
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
  <p v-if="confirmationMessage" class="confirmation-message">{{ confirmationMessage }}</p>
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
        { key: 'event.name', title: 'Event' },
      ],
      bookingElements: [],
      loading: true,
      confirmationMessage: '',
    };
  },
  components: { ListForm },
  methods: {
    async fetchBookings() {
      this.loading = true;
      this.bookingElements = [];
      try {
        const response = await axios.get('/api/bookings');
        const rawData = response.data.data;

        // معالجة البيانات لتفادي null في user أو event
        this.bookingElements = rawData.map(b => ({
          ...b,
          user: b.user || { name: 'No user data' },
          event: b.event || { name: 'No event data' },
        }));

        this.loading = false;

        // إرسال البريد بعد التحميل
        this.sendConfirmationEmails(this.bookingElements);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },

    async sendConfirmationEmails(bookings) {
      try {
        const emailResponse = await axios.post('/api/send-confirmation-emails', { bookings });

        if (emailResponse.status === 200) {
          this.confirmationMessage = 'Confirmation emails have been sent successfully!';
        } else {
          this.confirmationMessage = 'There was an error sending confirmation emails.';
        }
      } catch (error) {
        console.error('Error sending confirmation emails:', error);
        this.confirmationMessage = 'Error sending confirmation emails.';
      }
    },
  },
  created() {
    this.fetchBookings();
  },
};
</script>

<style scoped>
.confirmation-message {
  color: green;
  margin-top: 20px;
  font-weight: bold;
}
</style>
