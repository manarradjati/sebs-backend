<script>
import { useTheme } from 'vuetify'

import NavBarLayout from '@/views/Bookify/layout/elements/NavBar/NavBarLayout.vue'

// Components
import Footer from '@/views/Bookify/layout/elements/Footer.vue'
import TopBar from '@/views/Bookify/layout/elements/TopBar.vue'
import NavBar from '@/views/Bookify/layout/elements/NavBar.vue'

export default {
  data() {
    return {
      GoTopbutton:true,
    }
  },
  components:{
    useTheme,
    Footer,TopBar,NavBar,
    NavBarLayout
  },
  methods:{
    top(){
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
      });
    },
    handleScroll() {
      const scrollButton = document.querySelector('.scroll-to-top');
      if (scrollButton) {
        if (window.scrollY > 100) { // Change 100 to the scroll position you prefer
          scrollButton.style.display = 'block';
        } else {
          scrollButton.style.display = 'none';
        }
      }
    },
  },
  setup() {
    const vuetifyTheme = useTheme();
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },

  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
}
</script>

<template>
  <NavBarLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <TopBar :function_="toggleVerticalOverlayNavActive" />
    </template>

    
    <template #vertical-nav-content>
      <NavBar />
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>

    <VBadge
      v-if="GoTopbutton"
      class="scroll-to-top"
      color="#00897B"
      icon="bx-x"
      size="30"
      @click="()=>{GoTopbutton=!GoTopbutton}"
    >
      <template v-slot:badge>
        <v-icon size="13">bx-x</v-icon>
      </template>
      <VAvatar
        size="45"
        variant="tonal"
        color="primary"
        @click="top"
        clickable
      >
        <VIcon
          icon="bx-up-arrow-alt"
          size="35"
        />
      </VAvatar>
    </VBadge>
      
  </NavBarLayout>
</template>

<style lang="scss" scoped>
.scroll-to-top {
  position: fixed;
  bottom: 2rem; /* Adjust the distance from the bottom as needed */
  left: 2rem; /* Adjust the distance from the left as needed */
  display: none;
  cursor: pointer;
}
</style>
