<template>
  <VForm 
    ref="refForm" 
    class="mt-6"  
    @submit.prevent="submit()"
    v-model="valid"
  >
    <VCardText> Add Book</VCardText>
    <VRow>
    <!-- Title -->
    <VCol md="6" cols="12">
      <VTextField
        v-model="form.title"
        placeholder="Enter the book title"
        label="Title"
        :rules="getValidationRules(['required', 'isString'])"
      />
    </VCol>

    <!-- Author -->
    <VCol md="6" cols="12">
      <VSelect
        v-model="form.author_id"
        label="Author"
        placeholder="Select the author"
        :items="authors"
        :item-title="(item)=>`${item.id} - ${item.name}`"
        item-text="name"
        item-value="id"
        :rules="getValidationRules(['required', 'authorRequired'])"
      />
    </VCol>

    <!-- Genre -->
    <VCol md="6" cols="12">
      <VSelect
        v-model="form.genre_id"
        label="Genre"
        placeholder="Select the genre"
        :items="genres"
        :item-title="(item)=>`${item.id} - ${item.name}`"
        item-text="name"
        item-value="id"
        :rules="getValidationRules(['required'])"
      />
    </VCol>

    <!-- ISBN -->
    <VCol md="6" cols="12">
      <VTextField
        v-model="form.isbn"
        placeholder="Enter the ISBN"
        label="ISBN"
        :rules="getValidationRules(['required', 'isString'])"
      />
    </VCol>

    <!-- Publication Date -->
    <VCol  md="6" cols="12">
      <DatePicker
        ref="datePicker"
        :date="form.publication_date"
        placeholder="Select the publication date"
        label="Publication Date"
        :readonly="false"
        :rules="getValidationRules(['required','validDate'])"
        
      />
    </VCol>

    <!-- Price -->
    <VCol md="6" cols="12">
      <VTextField
        v-model="form.price"
        placeholder="Enter the price"
        label="Price"
        :rules="getValidationRules(['required', 'isNumeric'])"
      />
    </VCol>

    <!-- Stock Quantity -->
    <VCol md="6" cols="12">
      <VTextField
        v-model="form.stock_quantity"
        placeholder="Enter the stock quantity"
        label="Stock Quantity"
        :rules="getValidationRules(['required', 'isNumeric', 'integer'])"
      />
    </VCol>

    <!-- Submit Button -->
      <VCol
        cols="12"
        class="d-flex gap-4"
      >
        <VBtn type="submit">
          Save
        </VBtn>

        <VBtn
          color="secondary"
          variant="tonal"
          @click="resetForm"
        >
          Reset
        </VBtn>

        <VBtn
          type="reset"
          color="info"
        >
          Clear
        </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

export default {
  data(){
    return{
      id:null,
      valid: false,
      rules: {
        required: (v) => !!v || "هذا الحقل مطلوب.",
        requiredImage: (v) => !v || v.length === 0 ? "يرجى تحميل صورة." : true,
        integer: (v) => !v || /^\d+$/.test(v) || "الرجاء إدخال عدد صحيح صالح.",
        email: (v) => !v || /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(v) || "الرجاء إدخال عنوان بريد إلكتروني صالح.",
        minLength: (v) => !v || (v && v.length >= 6) || "يجب أن تحتوي هذه السلسلة على ما لا يقل عن 6 أحرف.",
        maxLength: (v) => !v || (v && v.length <= 255) || "يجب أن لا تتجاوز هذه السلسلة 255 حرفًا.",
        passwordMatch: (v1, v2) => v1 === null || v2 === null || (v1 === v2) || "كلمتا المرور غير متطابقتين.",
        validURL: (v) => !v || /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/.test(v) || "الرجاء إدخال رابط URL صالح.",
        positiveNumber: (v) => !v || (parseFloat(v) > 0) || "الرجاء إدخال رقم إيجابي.",
        validDate: (v) => !v || /^\d{4}-\d{2}-\d{2}$/.test(v) || "الرجاء إدخال تاريخ صالح بالصيغة YYYY-MM-DD.",
        isString: (v) => !v || typeof v === 'string' || "يجب أن يكون هذا الحقل نصًا.",
        isNumeric: (v) => !v || !isNaN(parseFloat(v)) || "يجب أن يكون هذا الحقل رقمًا.",
      },
      form:{
        title: '',
        author_id: null,
        genre_id: null,
        isbn: '',
        publication_date: null,
        price: null,
        stock_quantity: null,
      },
      authors: [
        {
          id: 1,
          name: "J.K. Rowling",
          biography: "Author of Harry Potter series",
          created_at: "2024-05-04T16:34:46.000000Z",
          updated_at: "2024-05-04T16:34:46.000000Z"
        },
        {
          id: 2,
          name: "J.K. Rowling",
          biography: "Author of Harry Potter series",
          created_at: "2024-05-04T16:34:46.000000Z",
          updated_at: "2024-05-04T16:34:46.000000Z"
        },
      ],
      genres: [
        {
          id: 1,
          name: "Fantasy",
          created_at: "2024-05-04T16:34:47.000000Z",
          updated_at: "2024-05-04T16:34:47.000000Z"
        },
        {
          id: 2,
          name: "Fantasy",
          created_at: "2024-05-04T16:34:47.000000Z",
          updated_at: "2024-05-04T16:34:47.000000Z"
        },
      ], 
      
      Sendform:null,
    }
  },
  props:['element'],
  methods: {
    submit(){
      if(this.valid){
        this.$nextTick(() => {
          // Access the selected date from the DatePicker component
          const selectedDate = this.$refs.datePicker.selectedDate;

          this.Sendform=this.form;

          // Include the selected date in the form data
          this.Sendform.publication_date = this.$refs.datePicker.selectedDate;

          // Modifier les autres champs selon votre modèle
          this.Sendform.author_id = this.form.author_id;
          this.Sendform.genre_id = this.form.genre_id;
          
          console.error(this.element)
          console.error(this.Sendform)

          axios
            .put('/api/book/'+this.element.id, this.Sendform)
            .then(response => {
              console.log(response);
                const formData = new FormData();
                formData.append('author_id', response.data.author_id); 
            })
            .catch(error => {
              console.error(error);
            });
        });
      }
     
    },

    getValidationRules(ruleNames) {
      return ruleNames.map(ruleName => this.rules[ruleName]);
    },
    resetForm(){
      this.form = _.cloneDeep(this.element);
    },
    init()
    {
      this.resetForm();

      axios.get('/api/author')
      .then(response => {
        this.authors = response.data; // Mettre à jour les auteurs avec les données récupérées
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des auteurs :', error);
      });

      axios.get('/api/genre')
      .then(response => {
        this.genres = response.data; // Mettre à jour les genres avec les données récupérées
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des genres :', error);
      });

    },

  },
  created(){
    this.init()
  },

  
}
</script>
