<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Update Review</VCardText>
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
          .put(`/api/review/${this.element.id}`, this.form)
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
    },
    created() {
      this.resetForm();
    },
  };
  </script>
  