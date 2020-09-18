<template>
  <div>
    <div class="d-flex flex-wrap">

        <v-card v-for="item in items" :key="item.id" max-width="344" class="d-flex flex-column justify-space-between ma-3 mt-0" elevation="1">
          <div>
            <div>
              <v-img src="/assets/images/pizza.jpg" width="100%" aspect-ratio="3" />
            </div>
            <v-card-title>{{ item.name }}</v-card-title>
            <v-card-text class="text-left">
              {{ item.description }}
            </v-card-text>
          </div>
          <v-card-actions>
            <v-chip dark color="green" class="ml-1">{{ item.price }} {{ item.price_currency }}</v-chip>
            <v-spacer></v-spacer>
            <v-btn text color="green">
              <v-icon left>mdi-cart</v-icon>

              В корзину
            </v-btn>
          </v-card-actions>
        </v-card>

    </div>
    <v-pagination
      v-model="page"
      :length="totalPages"
      prev-icon="mdi-menu-left"
      next-icon="mdi-menu-right"
    ></v-pagination>
  </div>
</template>

<script>
import AppLogo from '~/components/AppLogo.vue'

export default {
  components: {
    AppLogo
  },
  data(){
    return {
      page: 1,
      totalPages: 4,
      items: []
    }
  },
  async fetch(){
    const result = await this.$axios.$get('/api/product/list', {
      params: {
        page: this.page
      }
    });
    const {current_page, data, last_page} = result;
    this.page = current_page;
    this.totalPages = last_page;
    this.items = data;

    console.log(this.items);
  },
  watch: {
    'page': '$fetch',
    '$route.query': '$fetch'
  },

  // fetchOnServer: false
}
</script>

<style>
.container {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family: "Quicksand", "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* 1 */
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>

