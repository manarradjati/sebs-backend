<template>
  <VTextField
    v-model="selectedDate"
    :placeholder="placeholder"
    :label="label"
    id="flatpickr-date"
    :readonly="readonly"
    @click="openDatePicker"
    @keydown="handleKeyDown"
    ref="dateInput"
  ></VTextField>
</template>

<script>
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

export default {
  data() {
    return {
      flatpickrInstance: null, // Reference to the Flatpickr instance
      selectedDate: this.date,
    };
  },
  props: {
    date: String, // or whatever data type your 'date' prop is
    readonly: Boolean,
    label: String, // New prop for the label
    placeholder: String, // New prop for the placeholder
  },
  watch: {
    date(newDate) {
      this.selectedDate = newDate;
      if (this.flatpickrInstance) {
        this.flatpickrInstance.setDate(newDate, false); // Update Flatpickr's selected date
      }
    },
    readonly(newReadOnly) {
      if (this.flatpickrInstance) {
        this.flatpickrInstance._input.disabled = newReadOnly;
      }
    },
  },
  mounted() {
    this.initializeFlatpickr();
  },
  methods: {
    async initializeFlatpickr() {
      await this.$nextTick(); // Wait for the component to be fully mounted
      try {
        this.flatpickrInstance = flatpickr(this.$refs.dateInput.$el, {
          dateFormat: 'Y-m-d',
          monthSelectorType: 'static',
          defaultDate: this.selectedDate, // Set the default date for the calendar
          onClose: (selectedDates, dateStr) => {
            this.selectedDate = dateStr;
          },
        });

        this.flatpickrInstance._input.disabled = this.readonly;
      } catch (error) {
        console.error('Error initializing Flatpickr:', error);
      }
    },
    openDatePicker() {
      if (!this.readonly) {
        this.flatpickrInstance.open();
      }
    },
    handleKeyDown(event) {
      if (this.readonly) {
        event.preventDefault();
      }
    },
  },
  beforeUnmount() {
    if (this.flatpickrInstance) {
      this.flatpickrInstance.destroy();
    }
  },
};
</script>

<style scoped>
/* Add any scoped styles if needed */
</style>
