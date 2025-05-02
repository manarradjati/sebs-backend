<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Update Category</VCardText>
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
        axios.put(`/api/categories/${this.element.id}`, this.form)
          .then(res => console.log('Updated:', res.data))
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