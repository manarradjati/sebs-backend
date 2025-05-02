<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Update Ticket</VCardText>
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
  
        <!-- Event ID -->
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
          .put(`/api/ticket/${this.element.id}`, this.form)
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
      this.resetForm();
      this.fetchEvents();
    },
  };
  </script>
  