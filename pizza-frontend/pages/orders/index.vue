<template>

    <v-container class="d-flex flex-column align-stretch" style="width: 100%">
    <div>
      <h1 class="text-left">Заказы</h1>
    </div>
    <v-card :to="'/orders/order/' + order.id" v-for="order in orders" :key="order.id" class="mb-3">
      <v-card-title>Заказ №{{ order.id }}</v-card-title>
      <v-card-text class="text-left">{{ formatDate(order.created_at) }}</v-card-text>
    </v-card>
    </v-container>

</template>

<script>


export default {
  components: {

  },
  data(){
    return {
      'orders': [ // order items

      ]
    }
  },
  async fetch(){
    const result = await this.$axios.$get('/api/user/order/list');

    this.orders = result.data;

    console.log(result);
  },
  methods: {
    formatDate(dateString){
      const date = new Date(dateString);

      return date.toLocaleDateString()
    }
  }
}
</script>

<style>

</style>

