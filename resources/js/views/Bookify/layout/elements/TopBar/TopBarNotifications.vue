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
  <div>

    <VMenu
      v-model="notificationsmenu"
      :close-on-content-click="false"
      width="23rem"
      location="bottom end"
      offset="14px"
    >
      <template v-slot:activator="{ props }">
        <IconBtn class="cursor-pointer" v-bind="props">
          <VBadge
            color="error"
            :content="notifications.length"
            :dot="!allNotificationsRead && notifications.length === 0"
            v-if="notifications.length > 0 || (!allNotificationsRead && notifications.length === 0)"
            max="99"
          >
            <VIcon icon="bx-bell"/>
          </VBadge>
          <VIcon icon="bx-bell" v-else/>
        </IconBtn>
      </template>

      <VList>
        <!-- 👉 User Avatar & Name -->
        <VListItem>
          <!-- Left side: Title -->
          <VListItemTitle class="font-weight-semibold" style="font-weight: bold; font-size=30px;">
            Notifications
          </VListItemTitle>

          <!-- Right side: Icons -->
          <template #append>
            <VListItemAction end>
              <IconBtn class="cursor-pointer">
                <VIcon 
                  :icon="allNotificationsRead?'mdi-email-open-outline':'mdi-email-outline'"  
                  @Click="ChangeNotifictionsStatus()" 
                />
                
                <VTooltip
                  activator="parent"
                  scroll-strategy="close"
                  location="right"
                >
                  <span class="text-capitalize" v-if="allNotificationsRead">Mark all notifications as unread</span>
                  <span class="text-capitalize" v-else>Mark all notifications as read</span>
                </VTooltip>
              </IconBtn>
            </VListItemAction>
          </template>
        </VListItem>

        <VDivider class="my-2" />

        <!-- 👉 Notification Element -->
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

        <!-- Divider -->
        <VDivider class="my-2" />

        <!-- 👉 Logout -->
        <VBtn
          block
          variant="text"
        >
          View all notifications
        </VBtn>
      </VList>
    </VMenu>
    
  </div>
</template>
