<template>
  <div>
    <div class="text-center">
      <v-btn
        :disabled="loading"
        append-icon="mdi-refresh"
        text="Refresh"
        variant="outlined"
        @click="onClick"
      ></v-btn>
    </div>

    <v-data-table
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items-length="totalItems"
      :items="desserts"
      :loading="loading"
      item-value="name"
      @update:options="loadItems"

      density="compact"


      v-model="selected"
      show-select

      v-model:expanded="expanded"
      show-expand
    >
      <template v-slot:loading>
        <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
      </template>

      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Expandable Table</v-toolbar-title>
        </v-toolbar>
      </template>
      
      <template v-slot:expanded-row="{ columns, item }">
        <tr>
          <td :colspan="columns.length">More info about {{ item.name }}</td>
        </tr>
      </template>

      <template v-slot:header.id="{ column }">
        {{ column.title.toUpperCase() }}
      </template>

      <!-- <template v-slot:headers="{ columns, isSorted, getSortIcon, toggleSort }">
        <tr>
          <template v-for="column in columns" :key="column.key">
            <td>
              <span class="mr-2 cursor-pointer" @click="() => toggleSort(column)">{{ column.title }}</span>
              <template v-if="isSorted(column)">
                <v-icon :icon="getSortIcon(column)"></v-icon>
              </template>
              <v-icon v-if="column.removable" icon="$close" @click="() => remove(column.key)"></v-icon>
            </td>
          </template>
        </tr>
      </template> -->

      <template v-slot:item.calories="{ value }">
        <v-chip :color="getColor(value)">
          {{ value }}
        </v-chip>
      </template>

      <template v-slot:group-header="{ item, columns, toggleGroup, isGroupOpen }">
        <tr>
          <td :colspan="columns.length">
            {{ item.value ? 'Contains gluten' : 'Gluten free' }}
            <VBtn
              size="small"
              variant="text"
              :icon="isGroupOpen(item) ? '$expand' : '$next'"
              @click="toggleGroup(item)"
            ></VBtn>
          </td>
        </tr>
      </template>

    </v-data-table>
  </div>
</template>

<script>
  const desserts = [
    {
      name: 'Frozen Yogurt',
      calories: 159,
      fat: 6.0,
      carbs: 24,
      protein: 4.0,
      iron: '1',
    },
    {
      name: 'Jelly bean',
      calories: 375,
      fat: 0.0,
      carbs: 94,
      protein: 0.0,
      iron: '0',
    },
    {
      name: 'KitKat',
      calories: 518,
      fat: 26.0,
      carbs: 65,
      protein: 7,
      iron: '6',
    },
    {
      name: 'Eclair',
      calories: 262,
      fat: 16.0,
      carbs: 23,
      protein: 6.0,
      iron: '7',
    },
    {
      name: 'Gingerbread',
      calories: 356,
      fat: 16.0,
      carbs: 49,
      protein: 3.9,
      iron: '16',
    },
    {
      name: 'Ice cream sandwich',
      calories: 237,
      fat: 9.0,
      carbs: 37,
      protein: 4.3,
      iron: '1',
    },
    {
      name: 'Lollipop',
      calories: 392,
      fat: 0.2,
      carbs: 98,
      protein: 0,
      iron: '2',
    },
    {
      name: 'Cupcake',
      calories: 305,
      fat: 3.7,
      carbs: 67,
      protein: 4.3,
      iron: '8',
    },
    {
      name: 'Honeycomb',
      calories: 408,
      fat: 3.2,
      carbs: 87,
      protein: 6.5,
      iron: '45',
    },
    {
      name: 'Donut',
      calories: 452,
      fat: 25.0,
      carbs: 51,
      protein: 4.9,
      iron: '22',
    },
  ]

  const FakeAPI = {
    async fetch ({ page, itemsPerPage, sortBy }) {
      return new Promise(resolve => {
        setTimeout(() => {
          const start = (page - 1) * itemsPerPage
          const end = start + itemsPerPage
          const items = desserts.slice()

          if (sortBy.length) {
            const sortKey = sortBy[0].key
            const sortOrder = sortBy[0].order
            items.sort((a, b) => {
              const aValue = a[sortKey]
              const bValue = b[sortKey]
              return sortOrder === 'desc' ? bValue - aValue : aValue - bValue
            })
          }

          const paginated = items.slice(start, end)

          resolve({ items: paginated, total: items.length })
        }, 500)
      })
    },
  }

export default {
  data: () => ({
    expanded: [],
    selected: [],
    itemsPerPage: 5,

    serverItems: [],
    loading: true,
    totalItems: 0,

    groupBy: [
      {
        key: 'gluten',
        order: 'asc',
      },
    ],

    headers: [
      {
        title: 'Dessert (100g serving)',
        align: 'start',
        sortable: false,
        key: 'name',
      },
      { title: 'Calories', key: 'calories', align: 'end' },
      { title: 'Fat (g)', key: 'fat', align: 'end' },
      { title: 'Carbs (g)', key: 'carbs', align: 'end' },
      { title: 'Protein (g)', key: 'protein', align: 'end' },
      { title: 'Iron (%)', key: 'iron', align: 'end' },
    ],
    desserts: [
      {
        name: 'Frozen Yogurt',
        calories: 159,
        fat: 6.0,
        carbs: 24,
        protein: 4.0,
        iron: '1%',
        gluten: false,
      },
      {
        name: 'Ice cream sandwich',
        calories: 237,
        fat: 9.0,
        carbs: 37,
        protein: 4.3,
        iron: '1%',
        gluten: false,
      },
      {
        name: 'Eclair',
        calories: 262,
        fat: 16.0,
        carbs: 23,
        protein: 6.0,
        iron: '7%',
        gluten: true,
      },
      {
        name: 'Cupcake',
        calories: 305,
        fat: 3.7,
        carbs: 67,
        protein: 4.3,
        iron: '8%',
        gluten: true,
      },
      {
        name: 'Gingerbread',
        calories: 356,
        fat: 16.0,
        carbs: 49,
        protein: 3.9,
        iron: '16%',
        gluten: true,
      },
      {
        name: 'Jelly bean',
        calories: 375,
        fat: 0.0,
        carbs: 94,
        protein: 0.0,
        iron: '0%',
        gluten: false,
      },
      {
        name: 'Lollipop',
        calories: 392,
        fat: 0.2,
        carbs: 98,
        protein: 0,
        iron: '2%',
        gluten: false,
      },
      {
        name: 'Honeycomb',
        calories: 408,
        fat: 3.2,
        carbs: 87,
        protein: 6.5,
        iron: '45%',
        gluten: true,
      },
      {
        name: 'Donut',
        calories: 452,
        fat: 25.0,
        carbs: 51,
        protein: 4.9,
        iron: '22%',
        gluten: true,
      },
      {
        name: 'KitKat',
        calories: 518,
        fat: 26.0,
        carbs: 65,
        protein: 7,
        iron: '6%',
        gluten: true,
      },
    ],
    
  }),
  methods: {
    loadItems ({ page, itemsPerPage, sortBy }) {
      this.loading = true
      FakeAPI.fetch({ page, itemsPerPage, sortBy }).then(({ items, total }) => {
        this.serverItems = items
        this.totalItems = total
        this.loading = false
      })
    },
    onClick() {
      this.loading = true
      setTimeout(() => {
        this.loading = false
      }, 2000)
    },

    remove(key) {
      this.headers = this.headers.filter(header => header.key !== key)
    },

    getColor (calories) {
      if (calories > 100) return 'red'
      else if (calories > 50) return 'orange'
      else return 'green'
    },
  },
}
</script>
