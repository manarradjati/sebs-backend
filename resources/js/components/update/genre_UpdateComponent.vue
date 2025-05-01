<template>
  <VForm 
    ref="refForm" 
    class="mt-6"  
    @submit.prevent="submit()"
    v-model="valid"
  >
    <!-- <VCardText> Add Author </VCardText> -->
    <VRow>
      <!-- Name -->
      <VCol md="12" cols="12">
        <VTextField
          v-model="form.name"
          placeholder="Enter author name"
          label="Name"
          :rules="getValidationRules(['required', 'isString', 'maxLength255'])"
        />
      </VCol>

      <!-- Submit Button -->
      <VCol
        cols="12"
        class="d-flex gap-4"
      >
        <VBtn type="submit">
          Save
        </VBtn>

        <VBtn
          color="secondary"
          variant="tonal"
          @click="resetForm"
        >
          Reset
        </VBtn>

        <VBtn
          type="reset"
          color="info"
        >
          Clear
        </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

export default {
  data(){
    return{
      id:null,
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
      
      Sendform:null,
    }
  },
  props:['element'],
  methods: {
    submit(){
      if(this.valid){
        this.$nextTick(() => {
          this.Sendform=this.form;
          
          console.error(this.element)
          console.error(this.Sendform)

          axios
            .put('/api/genre/'+this.element.id, this.Sendform)
            .then(response => {
              console.log(response);
            })
            .catch(error => {
              console.error(error);
            });
        });
      }
     
    },

    getValidationRules(ruleNames) {
      return ruleNames.map(ruleName => this.rules[ruleName]);
    },
    resetForm(){
      this.form = _.cloneDeep(this.element);
    },
    init()
    {
      this.resetForm();
    },

  },
  created(){
    this.init()
  },

  
}
</script>
