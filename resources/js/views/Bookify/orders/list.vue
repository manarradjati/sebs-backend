<template lang="">
  <ListForm 
    :attributes="orderAttributes" 
    :elements="orderElements"
    cardtext="List of all orders"
    cardtitle="Orders"
    :tableLoading="loading"
    nakiraword="Order"
    gword="order"
    exportExcel="export/orders"
    :numfields="3"
    @fetchdata="fetchOrders"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      orderAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'user.name', title: 'Customer' },
        { key: 'total_amount', title: 'Total' },

        // { key: 'items', title: 'items' },
        // { key: 'book.title', title: 'Book' },
        // { key: 'quantity', title: 'Quantity' },
        // { key: 'order_date', title: 'Order Date' },
      ],
      orderElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchOrders() {
      this.loading = true;
      this.orderElements = [];
      try {
        const response = await axios.get('/api/order');
        this.orderElements = response.data.data;
        this.loading = false;
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchOrders();
  },
};
</script>
