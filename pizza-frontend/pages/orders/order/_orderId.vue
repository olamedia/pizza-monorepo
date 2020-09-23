<template>
  <v-container class="d-flex flex-column align-stretch justify-start" style="width: 100%">
    <h1 class="text-left">Заказ №{{ order.id }}</h1>
    <v-card v-for="item in items" :key ="item.id" class="mb-3">
      <v-card-title>item {{ item.id }}</v-card-title>
    </v-card>

  </v-container>
</template>

<script>
export default {
  name: "orderPage",
  data(){
    return {
      order: {},
      items: []
    }
  },
  async fetch(){
    try{
      const result = await this.$axios.$get('/api/user/order/' + this.$route.params.orderId)
      this.order = result.order;
      this.items = result.items;
    }catch ( error ){
      if ('response' in error && error.response.status === 403) {
        return await this.$auth.logout();
      }
    }
  }
}
</script>

