<template lang="">
  <div>
    <button @click="downloadAllTickets" class="btn-download">
      Download tickets (PDF)
    </button>

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
  </div>
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
      ticketElements: [
        {
          id: 1,
          ticket_number: 'TCK-001',
          qr_code_image: 'https://example.com/qrcode1.png',
          qr_code_pdf: 'https://example.com/ticket1.pdf',
          status: 'active',
          booking: { id: 101 }
        },
        {
          id: 2,
          ticket_number: 'TCK-002',
          qr_code_image: 'https://example.com/qrcode2.png',
          qr_code_pdf: 'https://example.com/ticket2.pdf',
          status: 'active',
          booking: { id: 102 }
        },
        {
          id: 3,
          ticket_number: 'TCK-003',
          qr_code_image: 'https://example.com/qrcode3.png',
          qr_code_pdf: 'https://example.com/ticket3.pdf',
          status: 'active',
          booking: { id: 103 }
        },
      ],
      loading: false, // set to false since we're using mock data
    };
  },
  components: { ListForm },
  methods: {
    async fetchTickets() {
      // هذه الدالة أصبحت غير ضرورية لأننا نستخدم بيانات وهمية الآن
      // ولكن يمكن استخدام fetch إذا كنت بحاجة إليها في المستقبل
      this.loading = true;
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

    async downloadAllTickets() {
      try {
        const response = await axios.get('/api/tickets/download-pdf', {
          responseType: 'blob' // Important to receive file
        });

        const blob = new Blob([response.data], { type: 'application/pdf' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'all_tickets.pdf';
        link.click();
      } catch (error) {
        console.error('Failed to download tickets:', error);
      }
    }
  },
  created() {
    // تعليق الاتصال بـ fetchTickets لأننا نستخدم بيانات وهمية الآن
    this.fetchTickets();
  },
};
</script>

<style scoped>
.btn-download {
  background-color: #2c3e50;
  color: white;
  padding: 10px 15px;
  margin-bottom: 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.btn-download:hover {
  background-color: #34495e;
}
</style>
