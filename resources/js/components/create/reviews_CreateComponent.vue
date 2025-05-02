<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Add Review</VCardText>
      <VRow>
        <!-- Review Title -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.title"
            label="Title"
            placeholder="Enter review title"
            :rules="getValidationRules(['required', 'isString'])"
          />
        </VCol>
  
        <!-- Review Content -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.content"
            label="Content"
            placeholder="Enter review content"
            :rules="getValidationRules(['required', 'isString'])"
          />
        </VCol>
  
        <!-- Rating -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.rating"
            label="Rating"
            placeholder="Enter rating (1-5)"
            :rules="getValidationRules(['required', 'isNumeric'])"
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
        form: {
          title: '',
          content: '',
          rating: '',
        },
        rules: {
          required: v => !!v || 'This field is required.',
          isString: v => !v || typeof v === 'string' || 'Must be a string.',
          isNumeric: v => !v || !isNaN(parseFloat(v)) || 'Must be a number.',
        },
      };
    },
    methods: {
      submit() {
        if (!this.valid) return;
        axios
          .post('/api/review', this.form)
          .then(res => {
            console.log('Created:', res.data);
          })
          .catch(err => console.error(err));
      },
      resetForm() {
        this.form = {
          title: '',
          content: '',
          rating: '',
        };
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
  