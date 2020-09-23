<template>
  <v-container class="d-flex flex-column align-stretch justify-start text-left" style="width: 100%">
    <h1 class="text-left">Заказ №{{ order.id }}</h1>
    <p>Кому: {{ order.full_name }}</p>
    <p>Адрес: {{ order.address }}</p>
    <OrderItemCard v-for="orderItem in items" :key="orderItem.id" :order-item="orderItem">

    </OrderItemCard>
    <v-divider></v-divider>
    <div class="text-right ma-3" v-if="order.delivery_price">
      Доставка <BasePriceChip :price="order.delivery_price" :currency="order.currency"></BasePriceChip>
    </div>
    <div class="text-right ma-3" v-if="order.total">
      Итого <BasePriceChip :price="order.total" :currency="order.currency"></BasePriceChip>
    </div>

  </v-container>
</template>

<script>
import OrderItemCard from "~/components/OrderItemCard";
import PriceChipInCurrentCurrency from "~/components/PriceChipInCurrentCurrency";
import TotalPriceChip from "~/components/TotalPriceChip";
import PriceChip from "~/components/PriceChip";
import BasePriceChip from "~/components/BasePriceChip";
export default {
  name: "orderPage",
  components: {BasePriceChip, PriceChip, TotalPriceChip, PriceChipInCurrentCurrency, OrderItemCard},
  data(){
    return {
      order: {},
      items: []
    }
  },
  async fetch(){
    try{
      const { order, items } = await this.$axios.$get('/api/user/order/' + this.$route.params.orderId)
      console.log({ order, items })
      this.order = order ? order : {};
      this.items = items ? items : [];
    }catch ( error ){
      if ('response' in error && error.response.status === 403) {
        return await this.$auth.logout();
      }
    }
  }
}
</script>

