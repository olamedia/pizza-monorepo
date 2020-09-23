<template>
  <v-container class="d-flex flex-column align-stretch justify-start" style="width: 100%">
    <h1 class="text-left">Корзина</h1>
    <div class="d-flex">
      <v-spacer class="flex-grow-1"></v-spacer>
      <CurrencySelect class="flex-grow-0"></CurrencySelect>
    </div>
    <OrderedProductCard v-for="cartItem in cartItems" :key="cartItem.product.id" :quantity="cartItem.quantity" :product="cartItem.product">

    </OrderedProductCard>
    <v-divider></v-divider>
    <div class="text-right ma-3" v-if="cartItemsNumber">
      Доставка <PriceChipInCurrentCurrency :price="10" :currency="'USD'"></PriceChipInCurrentCurrency>
    </div>
    <div class="text-right ma-3" v-if="cartItemsNumber">
      Итого <TotalPriceChip :items="totalItems"></TotalPriceChip>
    </div>
  </v-container>
</template>

<script>
import OrderedProductCard from "~/components/OrderedProductCard";
import CurrencySelect from "~/components/CurrencySelect";
import PriceChip from "~/components/PriceChip";
import PriceChipInCurrentCurrency from "~/components/PriceChipInCurrentCurrency";
import TotalPriceChip from "~/components/TotalPriceChip";

export default {
  components: {
    TotalPriceChip,
    PriceChipInCurrentCurrency,
    PriceChip,
    CurrencySelect,
    OrderedProductCard
  },
  data(){
    return {
      items: [],
      deliveryItem: {
        price: 10,
        currency: 'USD',
        quantity: 1
      },
      products: {}
    }
  },
  computed: {
    cartItems(){
      return this.$store.state.cart.items
    },
    cartItemsNumber(){
      return this.$store.getters["cart/totalItemsNumber"]
    },
    totalItems(){
      const totalItems = this.cartItems.map(cartItem => {
        const product = cartItem.product
        return {
          price: product.price,
          currency: product.price_currency,
          quantity: cartItem.quantity
        }
      })
      totalItems.push(this.deliveryItem)
      return totalItems
    },
  },
}
</script>


