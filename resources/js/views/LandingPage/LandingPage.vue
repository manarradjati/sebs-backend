<template>
     <v-app>
          <!-- Navigation bar with Login button -->
          <v-app-bar app color="indigo" dark>
               <v-toolbar-title> Bkevent</v-toolbar-title>
               <v-spacer />
               <v-btn color="secondary" @click="navigateToLogin">Login</v-btn>
          </v-app-bar>

          <!-- Hero section with background image and CTA -->
          <v-container fluid class="hero">
               <v-row align="center" justify="center" class="fill-height">
                    <v-col class="text-center" cols="12">
                    <h1 class="display-2 white--text">Welcome to  Bkevent</h1>
                    <v-btn color="pink" dark large @click="navigateToDashboard">
                    Discover Now
                    </v-btn>
                    </v-col>
               </v-row>
          </v-container>

          <!-- Featured Books Carousel -->
          <v-container>
          <v-row>
               <v-col>
               <h2>Featured Books</h2>
               <v-carousel hide-delimiter-background>
               <v-carousel-item v-for="(item, index) in featuredBooks" :key="index">
                    <v-card hover>
                    <v-img :src="item.image" aspect-ratio="2.0" />
                    <v-card-title>{{ item.title }}</v-card-title>
                    <v-card-subtitle>{{ item.author }}</v-card-subtitle>
                    <v-card-text>{{ item.description }}</v-card-text>
                    <v-card-actions>
                         <v-btn text color="primary">Buy Now</v-btn>
                    </v-card-actions>
                    </v-card>
               </v-carousel-item>
               </v-carousel>
               </v-col>
          </v-row>
          </v-container>

          <!-- Testimonial Section -->
          <v-container>
          <v-row>
               <v-col>
               <h2>What Our Readers Say</h2>
               <v-carousel cycle>
               <v-carousel-item
                    v-for="(testimonial, index) in testimonials"
                    :key="index"
               >
                    <v-card hover>
                    <v-card-title>{{ testimonial.name }}</v-card-title>
                    <v-card-text>
                         <em>{{ testimonial.text }}</em>
                    </v-card-text>
                    </v-card>
               </v-carousel-item>
               </v-carousel>
               </v-col>
          </v-row>
          </v-container>

          <!-- Footer -->
          <v-footer color="indigo" dark>
               <v-row align="center" justify="center">
                    <v-col cols="12" class="text-center white--text">
                    &copy; {{ currentYear }}  Bkevent. All rights reserved.
                    </v-col>
               </v-row>
          </v-footer>
     </v-app>
</template>

<script>
export default {
     data() {
          return {
          featuredBooks: [
               {
                    title: "The Great Gatsby",
                    author: "F. Scott Fitzgerald",
                    description: "A story of the Jazz Age in the United States.",
                    image:
                    "https://images.unsplash.com/photo-1559056199-26a0c9ab3b6e?ixlib=rb-1.2.1&q=80",
               },
               {
                    title: "To Kill a Mockingbird",
                    author: "Harper Lee",
                    description: "A novel about racial injustice.",
                    image:
                    "https://images.unsplash.com/photo-1524985069026-dd778a71f4b3?ixlib=rb-1.2.1&q=80",
               },
               {
                    title: "1984",
                    author: "George Orwell",
                    description: "A dystopian novel about totalitarianism.",
                    image:
                    "https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&q=80",
               },
          ],
          testimonials: [
               {
                    name: "John Doe",
                    text: "Bookify has changed the way I read! Love the collection.",
               },
               {
                    name: "Jane Smith",
                    text: "Great selection and excellent service!",
               },
          ],
          };
     },
     computed: {
          currentYear() {
               return new Date().getFullYear();
          },
     },
     methods: {
          navigateToLogin() {
               this.$router.push({ name: "Login" });
          },
          navigateToDashboard() {
               this.$router.push({ name: "Dashboard" });
          },
     },
};
</script>

<style scoped>
.hero {
     background-image: url('https://images.unsplash.com/photo-1529429614215-e93b846f545c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1400&q=80');
     background-size: cover;
     background-position: center;
     height: 400px;
}
</style>
   