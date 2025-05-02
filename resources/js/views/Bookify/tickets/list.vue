<template lang="">
  <ListForm 
    :attributes="ticketAttributes" 
    :elements="ticketElements"
    cardtext="List of all tickets"
    cardtitle="Tickets"
    :tableLoading="loading"
    nakiraword="Ticket"
    gword="tickets"
    exportExcel="export/tickets"
    :numfields="5"
    @fetchdata="fetchTickets"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      ticketAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'ticket_number', title: 'Ticket Number' },
        { key: 'qr_code_image', title: 'QR Code Image' },
        { key: 'qr_code_pdf', title: 'QR Code PDF' },
        { key: 'status', title: 'Status' },
        { key: 'booking.id', title: 'Booking ID' }, // assuming relationship is loaded
      ],
      ticketElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchTickets() {
      this.loading = true;
      this.ticketElements = [];
      try {
        const response = await axios.get('/api/tickets');
        this.ticketElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchTickets();
  },
};
</script>
