<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Add Booking</VCardText>
      <VRow>
        <VCol md="6" cols="12">
          <VSelect
            v-model="form.user_id"
            label="User"
            :items="users"
            :item-title="item => `${item.id} - ${item.name}`"
            item-value="id"
            :rules="getValidationRules(['required'])"
          />
        </VCol>
  
        <VCol md="6" cols="12">
          <VSelect
            v-model="form.ticket_id"
            label="Ticket"
            :items="tickets"
            :item-title="item => `${item.id} - ${item.title}`"
            item-value="id"
            :rules="getValidationRules(['required'])"
          />
        </VCol>
  
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.quantity"
            label="Quantity"
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
        users: [],
        tickets: [],
        form: {
          user_id: null,
          ticket_id: null,
          quantity: '',
        },
        rules: {
          required: v => !!v || 'This field is required.',
          integer: v => !v || /^\d+$/.test(v) || 'Must be an integer.',
        },
      };
    },
    methods: {
      submit() {
        if (!this.valid) return;
        axios.post('/api/bookings', this.form)
          .then(res => console.log('Created:', res.data))
          .catch(err => console.error(err));
      },
      resetForm() {
        this.form = {
          user_id: null,
          ticket_id: null,
          quantity: '',
        };
      },
      clearForm() {
        this.resetForm();
      },
      getValidationRules(ruleNames) {
        return ruleNames.map(rule => this.rules[rule]);
      },
      fetchOptions() {
        axios.get('/api/users').then(res => (this.users = res.data));
        axios.get('/api/tickets').then(res => (this.tickets = res.data));
      },
    },
    created() {
      this.fetchOptions();
    },
  };
  </script>
  