<template>
  <v-container class="d-flex flex-column align-stretch justify-start" style="width: 100%">
    <h1 class="text-left">Корзина</h1>
    <div>
      <v-alert type="success" v-if="sentOrder">
        Заказ отправлен
      </v-alert>
    </div>
    <div class="d-flex">
      <v-spacer class="flex-grow-1"></v-spacer>
      <CurrencySelect class="flex-grow-0"></CurrencySelect>
    </div>
    <OrderedProductCard v-for="cartItem in cartItems" :key="cartItem.product.id" :quantity="cartItem.quantity" :product="cartItem.product">

    </OrderedProductCard>
    <v-divider></v-divider>
    <div class="text-right ma-3" v-if="cartItemsNumber">
      Доставка <PriceChipInCurrentCurrency :price="deliveryItem.price" :currency="deliveryItem.currency"></PriceChipInCurrentCurrency>
    </div>
    <div class="text-right ma-3" v-if="cartItemsNumber">
      Итого <TotalPriceChip :items="totalItems"></TotalPriceChip>
    </div>

    <v-form v-if="cartItemsNumber">
      <v-text-field
        v-model="details.fullName"
        :rules="[rules.required]"
        label="ФИО"
        required
      ></v-text-field>

      <v-text-field
        v-model="details.address"
        :rules="[rules.required]"
        label="Адрес"
        required
      ></v-text-field>
    </v-form>

    <div class="text-right ma-3" v-if="cartItemsNumber">
      <v-btn large color="primary" @click="createOrder">Отправить заказ</v-btn>
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
      details: {
        fullName: '',
        address: ''
      },
      rules: {
        required: value => !!value || 'Required.',
      },
      sentOrder: false,
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
  methods: {
    async createOrder(){
      const { order } = await this.$axios.$post('/api/order', {
        items: this.cartItems.map(cartItem => {
          return {
            quantity: cartItem.quantity,
            product_id: cartItem.product.id
          }
        }),
        currency: this.$store.state.currency.currentCurrency,
        details: this.details,
        delivery: this.deliveryItem
      })
      await this.$store.commit('cart/clearCart')
      this.sentOrder = true
      if (order){
        if (this.$auth.loggedIn) {
          await this.$router.push('/orders/order/' + order.id)
        }
      }
    }
  }
}
</script>


