<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Add Ticket</VCardText>
      <VRow>
        <!-- Ticket Name -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.name"
            label="Ticket Name"
            placeholder="Enter ticket name"
            :rules="getValidationRules(['required', 'isString'])"
          />
        </VCol>
  
        <!-- Ticket Price -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.price"
            label="Price"
            placeholder="Enter ticket price"
            :rules="getValidationRules(['required', 'isNumeric'])"
          />
        </VCol>
  
        <!-- Ticket Quantity -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.quantity"
            label="Quantity"
            placeholder="Enter ticket quantity"
            :rules="getValidationRules(['required', 'integer'])"
          />
        </VCol>
  
        <!-- Event ID (Optional) -->
        <VCol md="6" cols="12">
          <VSelect
            v-model="form.event_id"
            label="Event"
            placeholder="Select event"
            :items="events"
            item-title="name"
            item-value="id"
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
        events: [],
        form: {
          name: '',
          price: '',
          quantity: '',
          event_id: null,
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
          .post('/api/ticket', this.form)
          .then(res => {
            console.log('Created:', res.data);
          })
          .catch(err => console.error(err));
      },
      resetForm() {
        this.form = {
          name: '',
          price: '',
          quantity: '',
          event_id: null,
        };
      },
      clearForm() {
        this.resetForm();
      },
      getValidationRules(ruleNames) {
        return ruleNames.map(rule => this.rules[rule]);
      },
      fetchEvents() {
        axios
          .get('/api/events')
          .then(res => {
            this.events = res.data;
          })
          .catch(err => console.error(err));
      },
    },
    created() {
      this.fetchEvents();
    },
  };
  </script>
  