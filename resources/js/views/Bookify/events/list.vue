<template>
  <div>
    <!-- زر لتصدير البيانات إلى Excel -->
    <button @click="exportToExcel">Export to Excel</button>

    <!-- مكون لعرض البيانات في جدول -->
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
      @edit="editEvent"
      @delete="deleteEvent"
    />
  </div>
</template>

<script>
import ListForm from '@/components/intern/ListForm.vue'
import axios from 'axios'
import * as XLSX from 'xlsx';  // استيراد مكتبة XLSX لتصدير البيانات إلى Excel

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
      eventElements: [],  // بيانات الأحداث
      loading: true,  // حالة التحميل
    };
  },
  components: { ListForm },
  methods: {
    // دالة جلب الأحداث من الخادم
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

    // دالة لتعديل الحدث
    async editEvent(eventId) {
      console.log(`Edit event with ID: ${eventId}`);
      // هنا يمكنك إضافة الكود لفتح نافذة تعديل أو تقديم استمارة تعديل
      // يمكن استدعاء API لتعديل الحدث عبر ID
    },

    // دالة لحذف الحدث
    async deleteEvent(eventId) {
      try {
        await axios.delete(`/api/events/${eventId}`);
        this.fetchEvents();  // تحديث البيانات بعد الحذف
      } catch (error) {
        console.error(`Failed to delete event with ID: ${eventId}`);
      }
    },

    // دالة لتصدير البيانات إلى Excel
    exportToExcel() {
      const ws = XLSX.utils.json_to_sheet(this.eventElements);  // تحويل البيانات إلى ورقة Excel
      const wb = XLSX.utils.book_new();  // إنشاء كتاب Excel جديد
      XLSX.utils.book_append_sheet(wb, ws, 'Events');  // إضافة الورقة إلى الكتاب
      XLSX.writeFile(wb, 'events.xlsx');  // تنزيل الملف
    },
  },
  created() {
    this.fetchEvents();  // جلب البيانات عند تحميل الصفحة
  },
};
</script>

<style scoped>
/* يمكن إضافة تنسيقات CSS هنا إذا لزم الأمر */
</style>
