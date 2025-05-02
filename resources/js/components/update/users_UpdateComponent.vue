<template>
    <VForm ref="refForm" class="mt-6" @submit.prevent="submit" v-model="valid">
      <VCardText>Update User</VCardText>
      <VRow>
        <!-- Username -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.username"
            label="Username"
            placeholder="Enter username"
            :rules="getValidationRules(['required', 'isString'])"
          />
        </VCol>
  
        <!-- Email -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.email"
            label="Email"
            placeholder="Enter email"
            :rules="getValidationRules(['required', 'isEmail'])"
          />
        </VCol>
  
        <!-- Password -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.password"
            label="Password"
            placeholder="Enter password"
            :rules="getValidationRules(['required'])"
            type="password"
          />
        </VCol>
  
        <!-- Confirm Password -->
        <VCol md="6" cols="12">
          <VTextField
            v-model="form.confirmPassword"
            label="Confirm Password"
            placeholder="Confirm password"
            :rules="getValidationRules(['required'])"
            type="password"
          />
        </VCol>
  
        <!-- Role -->
        <VCol md="6" cols="12">
          <VSelect
            v-model="form.role"
            label="Role"
            placeholder="Select role"
            :items="roles"
            item-title="name"
            item-value="id"
            :rules="getValidationRules(['required'])"
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
        roles: [],
        form: {
          username: '',
          email: '',
          password: '',
          confirmPassword: '',
          role: null,
        },
        rules: {
          required: v => !!v || 'This field is required.',
          isString: v => !v || typeof v === 'string' || 'Must be a string.',
          isEmail: v => /.+@.+\..+/.test(v) || 'Must be a valid email.',
        },
      };
    },
    methods: {
      submit() {
        if (!this.valid) return;
        if (this.form.password !== this.form.confirmPassword) {
          console.error("Passwords don't match");
          return;
        }
        axios
          .put(`/api/user/${this.element.id}`, this.form)
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
      fetchRoles() {
        axios
          .get('/api/roles')
          .then(res => {
            this.roles = res.data;
          })
          .catch(err => console.error(err));
      },
    },
    created() {
      this.resetForm();
      this.fetchRoles();
    },
  };
  </script>
  