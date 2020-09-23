<template>
  <v-container class="flex-column align-stretch">
  <div class="d-flex">
    <v-spacer class="flex-grow-1"></v-spacer>
    <CurrencySelect class="flex-grow-0"></CurrencySelect>
  </div>
    <div class="d-flex flex-wrap justify-space-between">

        <v-card v-for="product in products" :key="product.id" max-width="344" class="d-flex flex-column justify-space-between mb-3 mt-0" elevation="1">
          <div>
            <div>
              <v-img src="/assets/images/pizza.jpg" width="100%" aspect-ratio="3" />
            </div>
            <v-card-title>{{ product.name }}</v-card-title>
            <v-card-text class="text-left">
              {{ product.description }}
            </v-card-text>
          </div>
          <v-card-actions>
            <PriceChip :price="product.price" :currency="product.price_currency" :targetCurrency="currency"></PriceChip>
            <v-spacer></v-spacer>
            <v-btn text color="green" @click="modifyCartItem(product, 1)">
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
  </v-container>
</template>

<script>

import CurrencySelect from "~/components/CurrencySelect";
import PriceChip from "~/components/PriceChip";
import { saveCartThrottler } from "~/helpers/saveCartThrottler";

export default {
  components: {
    PriceChip,
    CurrencySelect,

  },
  data(){
    return {
      page: 1,
      totalPages: 4,
      products: []
    }
  },
  computed: {
    currency() {
      return this.$store.state.currency.currentCurrency
    }
  },
  methods: {
    async modifyCartItem(product, quantity){
      await this.$store.dispatch('cart/addProduct', {product, quantity})
      saveCartThrottler(async () => {
        await this.$store.dispatch('cart/saveUserCart', this.$axios)
      })
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
    this.products = data;

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

