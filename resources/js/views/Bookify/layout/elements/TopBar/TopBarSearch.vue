<template lang="">
  <div
    class="d-flex align-center cursor-pointer"
    style="user-select: none;"
  >

    <VDialog
      v-model="isDialogVisible"
      width="500"
      target="cursor"
      location="top"
      origin="center"
    >
      <!-- Activator -->
      <template #activator="{ props }">
        <!-- <VBtn v-bind="props">
          <VIcon icon="bx-search" />
        </VBtn> -->

        <!-- 👉 Search Trigger button -->
        <div v-bind="props" class="d-flex">
          <IconBtn @click="hideShowSearchInput">
            <VIcon icon="bx-search" />
          </IconBtn>
          <span class="d-none d-md-flex align-center text-disabled">
            <span class="me-3">Search</span>
            <span class="meta-key">&#x2318;K</span>
          </span>
        </div>
        
      </template>

      <!-- Dialog Content -->
      <VCard>
        <DialogCloseBtn
          variant="text"
          size="small"
          @click="isDialogVisible = false"
        />

        <VTextField 
          v-model="Search_Input"
          prepend-inner-icon="bx-search"
          :append-inner-icon="SearchResaultCard?'bx-chevron-up':'bx-chevron-down'"
          clearable
          :loading="loadingsearch"

          @click:prepend-inner="onLaunchSearch"
          @click:append-inner="onClickShowResalutCard"
        ></VTextField>
      </VCard>
      <v-expand-transition>
        <VCard   
          v-show="SearchResaultCard"
          title="apsldps" 
          text="poskpospodkspodkspd"
          transition="fade-transition"
        >
        </VCard>
      </v-expand-transition>
      
    </VDialog>

    <!-- <transition name="fade">
      <v-text-field 
        v-if="searchInputHidden"
        v-model="searchInput" 
        style="width: 12em; font-size: 12px; padding: 4px !important; box-sizing: border-box;"
        clearable
        hide-details="auto"
        variant="solo-filled"
        dense  
      />
    </transition> -->
    
    
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      isDialogVisible:false,
      searchInputHidden: true,
      searchInput: '', // Assuming you have a data property for searchInput

      Search_Input:null,
      SearchResaultCard:false,
      loadingsearch:false,
    }
  },
  methods: {
    hideShowSearchInput() {
      console.log('click');
      console.log(this.searchInputHidden);
      this.searchInputHidden = !this.searchInputHidden;
    },
    onClickShowResalutCard(){
      this.SearchResaultCard=!this.SearchResaultCard
    },
    onLaunchSearch(){
      this.loadingsearch=true
      axios
      .post('/api/search',{search:this.Search_Input})
      .then(response=>{
        console.log(response.data)
        this.SearchResaultCard=!this.SearchResaultCard
      })
      .catch(error=>{
        console.log(error.data)
      })
    }
  },
  
}
</script>

<style lang="">
  
</style>
