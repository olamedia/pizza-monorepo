<template>
  <v-card class="mb-3 d-flex flex-justify-stretch">
    <div>
      <v-img src="/assets/images/pizza.jpg" width="100" aspect-ratio="0.8" />
    </div>
    <div class="d-flex flex-grow-1">
      <div class="flex-grow-1">
        <v-card-title>{{ orderItem.name }}</v-card-title>
      </div>
      <div class="pa-3 flex-grow-0 price-quantity-grid">
        <div class="price-quantity-grid--price">
          <BasePriceChip :price="orderItem.price" :currency="orderItem.price_currency"></BasePriceChip>
          <span class="price-quantity-grid--sign">×</span>
        </div>
        <div class="price-quantity-grid--quantity">
          <span>
          {{ orderItem.quantity }}
            </span>
        </div>
        <div class="price-quantity-grid--total">
          <span class="price-quantity-grid--sign">=</span>
          <BasePriceChip :price="orderItem.price * orderItem.quantity" :currency="orderItem.price_currency"></BasePriceChip>
        </div>
      </div>
    </div>
    <slot></slot>
  </v-card>
</template>

<script>
import PriceChip from "~/components/PriceChip";

import { saveCartThrottler } from '~/helpers/saveCartThrottler'
import BasePriceChip from "~/components/BasePriceChip";

export default {
name: "OrderItemCard",
  components: {BasePriceChip, PriceChip},
  props: {
    orderItem: {
      type: Object,
      required: true
    }
  },
  computed: {
    currency() {
      return this.$store.state.currency.currentCurrency
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
