<template>
  <ListForm 
    :attributes="eventAttributes" 
    :elements="eventElements"
    cardtext="List of all events in the system"
    cardtitle="Events"
    :tableLoading="loading"
    nakiraword="Event"
    gword="events"
    exportExcel="export/events"
    :numfields="7"
    @fetchdata="fetchEvents"
  />
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'

export default {
  data() {
    return {
      eventAttributes: [
        { key: 'id', title: 'ID' },
        { key: 'title', title: 'Title' },
        { key: 'organizer.user.username', title: 'Organizer' },
        { key: 'category.name', title: 'Category' },
        { key: 'start_date', title: 'Start Date' },
        { key: 'end_date', title: 'End Date' },
        { key: 'price', title: 'Price' },
        { key: 'status', title: 'Status' },
        { key: 'is_approved', title: 'Approved' },
      ],
      eventElements: [],
      loading: true,
    };
  },
  components: { ListForm },
  methods: {
    async fetchEvents() {
      this.loading = true;
      this.eventElements = [];
      try {
        const response = await axios.get('/api/events');
        this.eventElements = response.data.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchEvents();
  },
};
</script>
