<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Add Category</VCardText>
      <VRow>
        <VCol cols="12">
          <VTextField
            v-model="form.name"
            label="Name"
            placeholder="Enter category name"
            :rules="getValidationRules(['required', 'isString'])"
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
  
  export default {
    data() {
      return {
        valid: false,
        form: {
          name: '',
        },
        rules: {
          required: v => !!v || 'This field is required.',
          isString: v => !v || typeof v === 'string' || 'Must be a string.',
        },
      };
    },
    methods: {
      submit() {
        if (!this.valid) return;
        axios.post('/api/categories', this.form)
          .then(res => console.log('Created:', res.data))
          .catch(err => console.error(err));
      },
      resetForm() {
        this.form = { name: '' };
      },
      clearForm() {
        this.resetForm();
      },
      getValidationRules(ruleNames) {
        return ruleNames.map(rule => this.rules[rule]);
      },
    },
  };
  </script>
  