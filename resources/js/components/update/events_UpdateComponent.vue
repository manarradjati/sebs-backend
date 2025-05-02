<template>
  <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
    <VCardText>Update Item</VCardText>
    <VRow>
      <VCol md="6" cols="12">
        <VTextField
          v-model="form.name"
          label="Name"
          placeholder="Enter item name"
          :rules="getValidationRules(['required', 'isString'])"
        />
      </VCol>

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

      <VCol md="6" cols="12">
        <VTextField
          v-model="form.price"
          label="Price"
          placeholder="Enter price"
          :rules="getValidationRules(['required', 'isNumeric'])"
        />
      </VCol>

      <VCol md="6" cols="12">
        <VTextField
          v-model="form.stock"
          label="Stock"
          placeholder="Enter stock quantity"
          :rules="getValidationRules(['required', 'integer'])"
        />
      </VCol>

      <VCol cols="12" class="d-flex gap-4">
        <VBtn type="submit">Update</VBtn>
        <VBtn color="secondary" variant="tonal" @click="resetForm">Reset</VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

export default {
  props: ['element'],
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
        .put(`/api/item/${this.element.id}`, this.form)
        .then(res => {
          console.log('Updated:', res.data);
        })
        .catch(err => console.error(err));
    },
    resetForm() {
      this.form = _.cloneDeep(this.element);
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
  },
  created() {
    this.resetForm();
    this.fetchTypes();
  },
};
</script>
