<template> 
  <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
    <VCardText>Add Item</VCardText>
    <VRow>
      <!-- Example Events -->
      <VCol cols="12">
        <VCardText class="mb-2">Example Events</VCardText>
        <VBtn class="me-2" @click="fillExample(1)">Concert</VBtn>
        <VBtn class="me-2" @click="fillExample(2)">Conference</VBtn>
        <VBtn @click="fillExample(3)">Festival</VBtn>
      </VCol>

      <!-- Item Name -->
      <VCol md="6" cols="12">
        <VTextField
          v-model="form.name"
          label="Name"
          placeholder="Enter item name"
          :rules="getValidationRules(['required', 'isString'])"
        />
      </VCol>

      <!-- Item Type -->
      <VCol md="6" cols="12">
        <VSelect
          v-model="form.type_id"
          label="Type"
          placeholder="Select type"
          :items="types"
          :item-title="item => `${item.id} - ${item.name}`"
          item-value="id"
          :rules="getValidationRules(['required'])"
        />
      </VCol>

      <!-- Price -->
      <VCol md="6" cols="12">
        <VTextField
          v-model="form.price"
          label="Price"
          placeholder="Enter price"
          :rules="getValidationRules(['required', 'isNumeric'])"
        />
      </VCol>

      <!-- Stock -->
      <VCol md="6" cols="12">
        <VTextField
          v-model="form.stock"
          label="Stock"
          placeholder="Enter stock quantity"
          :rules="getValidationRules(['required', 'integer'])"
        />
      </VCol>

      <VCol cols="12" class="d-flex gap-4">
        <VBtn type="submit">Save</VBtn>
        <VBtn color="secondary" variant="tonal" @click="resetForm">Reset</VBtn>
        <VBtn type="reset" color="info" @click="clearForm">Clear</VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

export default {
  data() {
    return {
      valid: false,
      types: [],
      form: {
        name: '',
        type_id: null,
        price: '',
        stock: '',
      },
      rules: {
        required: v => !!v || 'This field is required.',
        isString: v => !v || typeof v === 'string' || 'Must be a string.',
        isNumeric: v => !v || !isNaN(parseFloat(v)) || 'Must be a number.',
        integer: v => !v || /^\d+$/.test(v) || 'Must be an integer.',
      },
    };
  },
  methods: {
    submit() {
      if (!this.valid) return;
      axios
        .post('/api/item', this.form)
        .then(res => {
          console.log('Created:', res.data);
        })
        .catch(err => console.error(err));
    },
    resetForm() {
      this.form = {
        name: '',
        type_id: null,
        price: '',
        stock: '',
      };
    },
    clearForm() {
      this.resetForm();
    },
    getValidationRules(ruleNames) {
      return ruleNames.map(rule => this.rules[rule]);
    },
    fetchTypes() {
      axios
        .get('/api/categories')
        .then(res => {
          this.types = res.data;
        })
        .catch(err => console.error(err));
    },
    fillExample(type) {
      const examples = {
        1: {
          name: 'Live Concert Ticket',
          type_id: this.types[0]?.id || null,
          price: '100',
          stock: '150',
        },
        2: {
          name: 'Tech Conference Access',
          type_id: this.types[1]?.id || this.types[0]?.id || null,
          price: '200',
          stock: '300',
        },
        3: {
          name: 'Summer Festival Pass',
          type_id: this.types[2]?.id || this.types[0]?.id || null,
          price: '75',
          stock: '500',
        },
      };
      this.form = { ...examples[type] };
    },
  },
  created() {
    this.fetchTypes();
  },
};
</script>
