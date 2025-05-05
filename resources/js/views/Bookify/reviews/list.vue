<template>
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
        { key: 'booking_id', title: 'Booking ID' },
        { key: 'created_at', title: 'Created At' },   // عرض تاريخ الإنشاء
        { key: 'updated_at', title: 'Updated At' },   // عرض تاريخ التحديث
      ],
      reviewElements: [
        // بيانات افتراضية للمراجعات لعرض الجدول بشكل صحيح
        { 
          id: 1, 
          rating: 5, 
          review: "Amazing experience, everything was perfect!", 
          booking_id: 101, 
          created_at: "2025-04-25 10:00:00", 
          updated_at: "2025-04-26 12:30:00" 
        },
        { 
          id: 2, 
          rating: 4, 
          review: "Great event, but the food could have been better.", 
          booking_id: 102, 
          created_at: "2025-04-24 14:30:00", 
          updated_at: "2025-04-25 15:00:00" 
        },
        { 
          id: 3, 
          rating: 3, 
          review: "It was okay, the music was too loud for my taste.", 
          booking_id: 103, 
          created_at: "2025-04-22 19:00:00", 
          updated_at: "2025-04-23 08:00:00" 
        },
        { 
          id: 4, 
          rating: 5, 
          review: "Excellent organization and the venue was beautiful.", 
          booking_id: 104, 
          created_at: "2025-04-21 11:00:00", 
          updated_at: "2025-04-22 16:30:00" 
        },
        { 
          id: 5, 
          rating: 2, 
          review: "Too crowded, I couldn’t enjoy the event as I expected.", 
          booking_id: 105, 
          created_at: "2025-04-20 13:30:00", 
          updated_at: "2025-04-20 14:00:00" 
        }
      ],   // بيانات افتراضية
      loading: false,
    };
  },
  components: { ListForm },
  methods: {
    async fetchReviews() {
      this.loading = true;
      try {
        // إرسال طلب GET إلى API لتحميل البيانات
        const response = await axios.get('/api/reviews');
        console.log('Data received:', response.data.data);  // طباعة البيانات في الـ Console لنتحقق منها
        this.reviewElements = response.data.data;  // تحديث المصفوفة بالبيانات المستلمة
        this.loading = false;
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchReviews();  // تحميل البيانات عند إنشاء المكون
  },
};


{/* < t emplate>
  <div>
    <table v-if="elements.length > 0">
      <thead>
        <tr>
          <th v-for="attribute in attributes" :key="attribute.key">{{ attribute.title }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(element, index) in elements" :key="index">
          <td v-for="attribute in attributes" :key="attribute.key">
            {{ getNestedValue(element, attribute.key) }}
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>No data available</p>  <!-- إذا كانت البيانات فارغة -->
  </div>
< / t emplate> */}

{/* < script>
export default {
  props: {
    attributes: Array,  // خصائص الجدول (مثل "ID" و "Rating")
    elements: Array,    // البيانات التي سيتم عرضها
  },
  methods: {
    // هذه الطريقة لاستخراج القيم إذا كان لدينا مفاتيح متداخلة (مثل `user.name`)
    getNestedValue(object, key) {
      return key.split('.').reduce((acc, part) => acc && acc[part], object) || '-';
    }
  }
}
< /script> */}
</script>


