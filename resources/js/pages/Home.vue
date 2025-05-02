<template>
    <div>
      <h1>قائمة التظاهرات</h1>
      <ul>
        <li v-for="event in events" :key="event.id">
          <router-link :to="`/events/${event.id}`">{{ event.title }}</router-link>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        events: [
          { id: 1, title: 'تظاهرة رياضية' },
          { id: 2, title: 'حفل موسيقي' }
        ]
      }
    }
  }
  </script>
  