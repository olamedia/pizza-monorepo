<template>
  <no-ssr>
  <v-tabs align-with-title>
    <v-tab v-for="item in items" :key="item.to" :to="item.to" :exact="item.exact">
      {{ item.title }}
      <CartBadge v-if="item.cartBadge"/>
<!--      <OrdersBadge v-if="item.ordersBadge"/>-->
    </v-tab>
  </v-tabs>
  </no-ssr>
</template>

<script>
import CartBadge from "~/components/CartBadge";
import OrdersBadge from "~/components/OrdersBadge";

export default {
  name: "AppTabs",
  components: {OrdersBadge, CartBadge},
  data() {
    return {}
  },
  computed: {
    items() {
      const tabs = [
        {title: 'Меню', exact: true, to: '/'},
        {title: 'Корзина', exact: false, to: '/cart', cartBadge: true},
      ]
      if (this.$auth.loggedIn) {
        tabs.push({title: 'Заказы', exact: false, to: '/orders', ordersBadge: true})
      }
      return tabs
    }
  }
}
</script>

<style scoped>

</style>
