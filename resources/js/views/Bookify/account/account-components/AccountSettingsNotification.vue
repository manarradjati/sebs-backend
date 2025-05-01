<script>
import { useStore } from 'vuex';

export default{
  data(){
    return{
      notificationsmenu:false,

      allNotificationsRead:false,
      notificationsLoaded:true,

      notifications:[
        {
          text:'A new member has been added to the student list of the Memorization Department for the Amor branch for all teaching periods.',
          timing:'January 26, 2024',
          viewed:false,
          image:null,
          icon:'bx-server'
        },
        {
          text:'A new member has been added to the student list of the Memorization Department for the Amor branch for all teaching periods.',
          timing:'January 26, 2024',
          viewed:true,
          image:null,
          icon:'bx-alarm-exclamation'
        },

      ]
      
    }
  },
  // props:['notifications'],
  methods:{
    ChangeNotifictionsStatus(){
      console.log("aaaa")
      console.log(this.allNotificationsRead)
      this.allNotificationsRead=!this.allNotificationsRead
    },
  },
  computed:{

  },
  created() {
    console.log(this.notifications.length)
  },
}
</script>

<template>
  <VCard title="Notifications">
    <div class="p-5 m-5">
      <VListItem
        v-if="notificationsLoaded" 
        v-for="notification in notifications" 
        :key="notification.id"
        @click="$router.push('/account-settings')" 
        link
        lines="two"
        active-color="primary"
      >

        <template v-slot:append>
          <VBadge
            v-if="!notification.viewed"
            color="info"
            dot
          ></VBadge>
        </template>

        <template #prepend>
          <VAvatar
            size="40"
            variant="tonal"
            color="primary"
          >
            <VIcon
              :icon="notification.icon"
              size="22"
              v-if="notification.icon"
            />

            <VImg 
              v-else-if="notification.image"
              :src="notification.image" 
            />

          </VAvatar>
        </template>


        <VListItemSubtitle :class="notification.viewed?'':'font-weight-bold'" style="font-size:17px;padding-bottom:-2rem;">
          {{ notification.text }}
        </VListItemSubtitle>

        <VListItemSubtitle :class="notification.viewed?'':'text-info'" style="font-size:12px">{{ notification.timing }}</VListItemSubtitle>
      </VListItem>

      <!-- 👉 Notification Loader Element -->
      <VListItem v-else v-for="n in 3" :key="n" link style="padding:0;">
        <v-skeleton-loader
            class="mx-auto"
            type="avatar, sentences"
          ></v-skeleton-loader>
      </VListItem>
    </div>
  </VCard>
</template>
