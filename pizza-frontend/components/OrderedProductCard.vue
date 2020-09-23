<template>
  <v-card class="mb-3 d-flex flex-justify-stretch">
    <div>
      <v-img src="/assets/images/pizza.jpg" width="100" aspect-ratio="0.8" />
    </div>
    <div class="d-flex flex-grow-1">
      <div class="flex-grow-1">
        <v-card-title>{{ product.name }}</v-card-title>
        <v-card-text class="text-left">{{ product.description }}</v-card-text>
      </div>
      <div class="pa-3 flex-grow-0 price-quantity-grid">
        <div class="price-quantity-grid--price">
          <PriceChip :price="product.price" :currency="product.price_currency" :targetCurrency="currency"></PriceChip>
          <span class="price-quantity-grid--sign">×</span>
        </div>
        <div class="price-quantity-grid--quantity">
          <span>
          {{ quantity }}
            </span>
        </div>
        <div class="price-quantity-grid--increment">
          <v-btn @click="modifyCartItem(product, 1)" small icon><v-icon>mdi-plus</v-icon></v-btn>
        </div>
        <div class="price-quantity-grid--decrement">
          <v-btn @click="modifyCartItem(product, -1)" small icon><v-icon>mdi-minus</v-icon></v-btn>
        </div>
        <div class="price-quantity-grid--total">
          <span class="price-quantity-grid--sign">=</span>
          <PriceChip :price="product.price" :currency="product.price_currency" :targetCurrency="currency" :quantity="quantity"></PriceChip>
        </div>
      </div>
    </div>
    <slot></slot>
  </v-card>
</template>

<script>
import PriceChip from "~/components/PriceChip";

import { saveCartThrottler } from '~/helpers/saveCartThrottler'

export default {
name: "OrderedProductCard",
  components: {PriceChip},
  props: {
    quantity: {
      type: Number,
      required: true
    },
    product: {
      type: Object,
      required: true
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
      if (this.$auth.loggedIn) {
        saveCartThrottler(async () => {
          await this.$store.dispatch('cart/saveUserCart', this.$axios)
        })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.price-quantity-grid{
  display: grid;
  grid-template-columns: repeat(3, max-content);
  grid-template-rows: repeat(3, max-content);
  grid-template-areas:
    ". i ."
    "p q t"
    ". d .";
  & > div{
    align-self: center !important;
  }
  .price-quantity-grid--price{
    grid-area: p;
    text-align: right;
  }
  .price-quantity-grid--quantity{
    grid-area: q;
    text-align: center;
    span {
      vertical-align: middle;
    }
  }
  .price-quantity-grid--total{
    grid-area: t;
  }
  .price-quantity-grid--increment{
    grid-area: i;
  }
  .price-quantity-grid--decrement{
    grid-area: d;
  }
  .price-quantity-grid--sign{
    display: inline-block;
    vertical-align: middle;
  }
}
</style>
