<template>
  <VForm 
    ref="refForm" 
    class="mt-6"
    v-model="valid"
    @submit.prevent="submit()"
  >
    <!-- <VCardText> Add Author </VCardText> -->
    <VRow>
      <!-- Name -->
      <VCol md="12" cols="12">
        <VTextField
          v-model="form.name"
          placeholder="Enter Genre name"
          label="Name"
          :rules="getValidationRules(['required', 'isString', 'maxLength255'])"
        />
      </VCol>

      <!-- Submit and Reset Buttons -->
      <VCol cols="12" class="d-flex gap-4">
        <VBtn type="submit">Submit</VBtn>
        <VBtn
          type="reset"
          color="secondary"
          variant="tonal"
          @click="resetForm()"
        >
          Reset
        </VBtn>
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
      rules: {
        required: (v) => !!v || "This field is required.",
        integer: (v) => /^\d+$/.test(v) || "Please enter a valid integer.",
        isString: (v) => typeof v === 'string' || "This must be a string.",
        maxLength255: (v) => v.length <= 255 || "Maximum 255 characters.",
      },
      form: {
        id: '',
        name: '',
      },
    };
  },
  methods: {
    submit() {
      if (this.valid) {
        axios
          .post('/api/genre', this.form)
          .then((response) => {
            console.log('Author added:', response.data);
            this.resetForm();
          })
          .catch((error) => {
            console.error('Error adding author:', error);
          });
      }
    },
    getValidationRules(ruleNames) {
      return ruleNames.map((ruleName) => this.rules[ruleName]);
    },
    resetForm() {
      this.form = {
        id: '',
        name: '',
      };
      this.$refs.refForm.reset();
    },
  },
};
</script>

<style scoped>
/* Add any specific styles for this component here */
</style>
