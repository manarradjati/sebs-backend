<template>
  <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
    <VCardText>Add Ticket</VCardText>
    <VRow>
      <!-- Example Tickets -->
      <VCol cols="12">
        <VCardText class="mb-2">Example Tickets</VCardText>
        <VBtn class="me-2" @click="fillExample(1)">VIP Ticket</VBtn>
        <VBtn class="me-2" @click="fillExample(2)">Standard Ticket</VBtn>
        <VBtn @click="fillExample(3)">Student Ticket</VBtn>
      </VCol>

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

      <!-- Buttons -->
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
    fillExample(type) {
      const examples = {
        1: {
          name: 'VIP Pass',
          price: '150',
          quantity: '50',
          event_id: this.events[0]?.id || null,
        },
        2: {
          name: 'Standard Admission',
          price: '50',
          quantity: '200',
          event_id: this.events[0]?.id || null,
        },
        3: {
          name: 'Student Ticket',
          price: '25',
          quantity: '100',
          event_id: this.events[0]?.id || null,
        },
      };
      this.form = { ...examples[type] };
    },
  },
  created() {
    this.fetchEvents();
  },
};
</script>
