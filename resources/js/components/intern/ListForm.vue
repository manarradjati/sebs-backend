<template>
  <div>
    <VCard :loading="tableLoading">
      <VCardItem v-if="state=='list'">
        <VCardTitle class="d-flex justify-space-between">
          <div>
            <h2 class="headline">{{ cardtitle }}</h2>
            <VTooltip
              location="top"
              activator="parent"
            >
            {{ cardtext }}
            </VTooltip>
          </div>
          
          <div class="d-flex">
            <IconBtn 
              @click="loadPageAgain"
              size="55"
            >
              <VIcon
                size="35"
                icon="mdi-refresh"
              />

              <VTooltip
                location="top"
                activator="parent"
              >
              Update
              </VTooltip>
            </IconBtn>

            <IconBtn 
              v-if="exportExcel"
              @click="exportToExcel"
              :loading="downloadisLoading"  
              size="55"
            >
            <!-- export to excel -->
              <VIcon
                size="30"
                icon="file-icons:microsoft-excel"
              />
              <VTooltip
                location="top"
                activator="parent"
                size="50"
              >
              get Excel version of the {{ nakiraword }} list
              </VTooltip>
            </IconBtn>

            <IconBtn 
              @click="loadCreatePage"
              size="55"
            >
              <VIcon
                size="37"
                icon="basil:add-outline"
              />

              <VTooltip
                location="top"
                activator="parent"
              >
              add new {{ nakiraword }}
              </VTooltip>
            </IconBtn>
          </div>
        </VCardTitle>
        
        <VCardText>
          <v-text-field 
            v-model="searchInput" 
            style="width: 12em; height: 10px !important;"
            clearable
            hide-details="auto"
            variant="underlined"
            label="Search"
            prepend-icon="bx-search"
          >
            <VTooltip location="top" activator="parent">
              Search
            </VTooltip>
          </v-text-field>
        </VCardText>

        <br>

        <!-- <div style="display: flex; justify-content: space-between;">
          <VCardText>{{ cardtext }}</VCardText>
          <VCardText>
            <v-text-field 
              v-model="searchInput" 
              style="width: 10em; height: 10px !important;"
              clearable
              hide-details="auto"
              variant="underlined"
              label="بحث"
              prepend-icon="bx-search"
            >
              <VTooltip location="top" activator="parent">
                بحث
              </VTooltip>
            </v-text-field>
          </VCardText>
        </div> -->


        <v-data-table
          :headers="visibleAttributes"
          :items="elements"
          :height="height"
          :items-per-page="10"
          class="elevation-1"
          :search="searchInput"
        >

          <template v-slot:header="{ visibleAttributes }">
            <thead>
              <tr>
                <th v-for="header in visibleAttributes" :key="header.key">
                  {{ header.title }}
                </th>
                <th>Actions1</th>
                <th>Acdddtions1</th>
              </tr>
            </thead>
          </template>

          <template v-slot:item="{ item }">
            <tr>
              <td v-for="attribute in visibleAttributes" :key="attribute.key">
                {{ getNestedPropertyValue(item, attribute.key) }}
              </td>

              <td>
                <IconBtn>
                  <VIcon icon="bx-dots-vertical" size="20" />

                  <VMenu
                    activator="parent"
                  >
                    <VList>
                      <VListItem>
                        <IconBtn @click="viewAction(item)" :loading="downloadisLoading">
                          <VIcon icon="mdi-eye" size="20" />
                          <VTooltip
                            activator="parent"
                            scroll-strategy="close" 
                          >
                            see details of the {{ nakiraword }}
                          </VTooltip>
                        </IconBtn>
                      </VListItem>

                      <VListItem>
                        <IconBtn @click="updateAction(item)" :loading="downloadisLoading">
                          <VIcon icon="mdi-pencil" size="20" />
                          <VTooltip
                            activator="parent"
                            scroll-strategy="close" 
                          >
                            edit info of the {{ nakiraword }}
                          </VTooltip>
                        </IconBtn>
                      </VListItem>

                      <VListItem class="d-flex align-center justify-center justify-content-center">
                        <IconBtn @click="deleteAction(item)" :loading="downloadisLoading">
                          <VIcon icon="mdi-delete" size="20" />
                          <VTooltip
                            activator="parent"
                            scroll-strategy="close" 
                          >
                            delete the {{ nakiraword }}
                          </VTooltip>
                        </IconBtn>
                      </VListItem>
                    </VList>
                  </VMenu>
                </IconBtn>
              </td>
            </tr>
          </template>
        </v-data-table>

      </VCardItem>

      <VCardItem v-else-if="state=='create'">
        <div class="d-flex gap-x-5 align-center">
          <div class="me-n3">
            <IconBtn @click="goback()">
              <VIcon icon="bx-arrow-back" />
              <VTooltip
                activator="parent"
                scroll-strategy="close" 
              >
                Go Back
              </VTooltip>
            </IconBtn>
          </div>
          <VCardTitle>add a new {{nakiraword}}</VCardTitle>
        </div>

        <component :is="CreateComponent" @itemCreated="goback()" />
      </VCardItem>

      <VCardItem v-else-if="state=='update'">
        <div class="d-flex gap-x-5 align-center">
          <div class="me-n3">
            <IconBtn @click="goback()">
              <VIcon icon="bx-arrow-back" />
              <VTooltip
                activator="parent"
                scroll-strategy="close" 
              >
                Go Back
              </VTooltip>
            </IconBtn>
          </div>
          <VCardTitle>edit info of the {{nakiraword}}</VCardTitle>
        </div>

        <component :is="UpdateComponent" @itemUpdated="goback()" :element="selectedElement" />
      </VCardItem>

      <VCardItem v-else-if="state=='view-item'">
        <div class="d-flex gap-x-5 align-center">
          <div class="me-n3">
            <IconBtn @click="goback()">
              <VIcon icon="bx-arrow-back" />
              <VTooltip
                activator="parent"
                scroll-strategy="close" 
              >
                Go Back
              </VTooltip>
            </IconBtn>
          </div>
          <VCardTitle>details of the {{nakiraword}}</VCardTitle>
        </div>
        
        <VCardText>
          <VTable>
            <tbody>
              <tr v-for="attribute in attributes" :key="attribute.key">
                <td>
                  <span class="text-subtitle-1 text-no-wrap font-weight-bold">
                    {{ attribute.title || attribute.key }}
                  </span>
                </td>
                <td>
                  <p class="text-subtitle-1 text-truncate mb-1">
                    {{ getNestedPropertyValue(selectedElement, attribute.key) }}
                  </p>
                </td>
              </tr>
            </tbody>
          </VTable>
        </VCardText>

      </VCardItem>
    </VCard>
  </div>  
</template>

<script>
import axios from 'axios';
import { markRaw } from 'vue';
import * as XLSX from 'xlsx';
// import $ from 'jquery';

export default {
  data(){
    return{
      downloadisLoading: false,

      CreateComponent:null,
      UpdateComponent:null,

      state:"list",
      selectedElement:null,

      height:this.tableheight || null,

      searchInput:null,
    }
  },
  props: [
    'attributes',
    'elements', 
    'cardtext', 
    'cardtitle',
    'tableLoading',
    'gword',
    'nakiraword',
    'exportExcel',
    'numfields',
    'tableheight'
  ],
  methods: {
    getNestedPropertyValue(obj, path) {
      if (!obj || !path) {
        return ''; // Handle cases where obj or path is undefined or null
      }

      // Split the path by dot to access nested properties
      const pathArray = path.split('.');
      let value = obj;

      // Traverse the object using the path
      for (const prop of pathArray) {
        if (value && value.hasOwnProperty(prop)) {
          value = value[prop];
        } else {
          return ''; // Return an empty string if the property doesn't exist
        }
      }

      return value;
    },

    exportToExcel() {
      try {
        this.downloadisLoading = true; // Indicate loading

        // Get data to export
        const dataToExport = this.elements.map((item) => {
          const row = {};
          for (const attribute of this.visibleAttributes) {
            row[attribute.title] = this.getNestedPropertyValue(item, attribute.key);
          }
          return row;
        });

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.json_to_sheet(dataToExport);

        // Set column widths
        const columnWidths = this.visibleAttributes.map((attribute) => {
          const maxLength = Math.min(
            Math.max(
              ...dataToExport.map((item) => item[attribute.title]?.toString().length || 0),
              attribute.title.length
            ),
            20
          );
          return { wch: maxLength }; // Character width (maximum 20)
        });

        worksheet['!cols'] = columnWidths;

        // Style the header row with a solid background color
        const headerRange = XLSX.utils.decode_range(worksheet['!ref']);
        const headerRow = headerRange.s.r; // Start row of the sheet

        // Desired color code for the header background (solid color)
        const headerBackgroundColor = '#c5175c'; // Example solid color

        for (let col = headerRange.s.c; col <= headerRange.e.c; col++) {
          const cellAddress = XLSX.utils.encode_cell({ r: headerRow, c: col });
          const cell = worksheet[cellAddress];

          if (cell) {
            cell.s = {
              fill: {
                fgColor: { rgb: headerBackgroundColor.replace('#', 'FF') },
              },
              font: {
                bold: true,
                color: { rgb: 'FFFFFFFF' }, // White text
              },
              alignment: {
                horizontal: 'center',
                vertical: 'center',
              },
            };
          }
        }

        // Add the worksheet to the workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

        // Save the workbook to a file
        const filename = `${this.gword}_export_${new Date().toISOString().slice(0, 10)}.xlsx`;
        XLSX.writeFile(workbook, filename);

        this.downloadisLoading = false; // Reset loading state
      } catch (error) {
        console.error('Error exporting data to Excel:', error);
        this.downloadisLoading = false;
      }
    },

    async loadCreatePage() {
      try {
        this.state = 'create';
        
        // Construct the component name dynamically based on your logic
        const componentName = this.gword + '_CreateComponent';
        
        // Dynamically import the component
        const { default: DynamicComponent } = await import(`@/components/create/${componentName}.vue`);
        
        // Set the CreateComponent to the imported component
        this.CreateComponent = markRaw(DynamicComponent);
      } catch (error) {
        console.error(error);
      }
    },

    async loadupdatePage(element) {
      try {
        this.state = 'update';
        
        // Construct the component name dynamically based on your logic
        const componentName = this.gword + '_UpdateComponent';
        
        // Dynamically import the component
        const { default: DynamicComponent } = await import(`@/components/update/${componentName}.vue`);
        
        // Set the UpdateComponent to the imported component
        this.UpdateComponent = markRaw(DynamicComponent);
        this.selectedElement=element;
      } catch (error) {
        console.error(error);
      }
    },

    viewAction(element) {
      this.state='view-item'
      this.selectedElement=element;
      // Implement your view action logic here
      console.log('View action for:', element);
    },
    updateAction(element) {
      // Implement your update action logic here
      console.log('Update action for:', element);
      this.loadupdatePage(element);
    },
    deleteAction(element) {
      // Implement your delete action logic here
      axios
      .delete('/api/'+this.gword+'/'+element.id)
      .then(response=>{
       console.log(response.data) 
      })
      .catch(error=>{
        console.error(error) 
      })

      console.log('Delete action for:', element);
    },

    goback(){
      this.state='list'
    },

    loadPageAgain(){
      // this.tableLoading = true
      //   setTimeout(() => {
      //     this.tableLoading = false
      //   }, 2000)

      this.$emit('fetchdata');
    }
  },
  computed: {
    visibleAttributes() {
      if (this.numfields <= 0) {
        // If numfields is null, display all attributes
        return this.attributes.map(attribute => ({ title: attribute.title,key:attribute.key }));
      } else {
        // Slice the attributes array based on the numfields prop
        return this.attributes.slice(0, this.numfields).map(attribute => ({ title: attribute.title,key:attribute.key }));
      }
    },
  },
  created(){
    // this.$nextTick(() => {
    //   $(this.$refs.dataTable.$el).DataTable();
    // });
  },
};
</script>

<style scoped>
/* Add CSS styles to customize the appearance of the actions */
.actions {
  display: flex;
  justify-content: space-around;
  padding: 8px;
  background-color: #f5f5f5;
}
</style>
