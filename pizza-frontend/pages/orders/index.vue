<template>

    <v-container class="d-flex flex-column align-stretch justify-start">
    <div>
      <h1 class="text-left">Заказы</h1>
    </div>
    <v-card :to="'/orders/order/' + order.id" v-for="order in orders" :key="order.id" class="mb-3">
      <v-card-title>Заказ №{{ order.id }}</v-card-title>
      <v-card-text class="text-left">{{ formatDate(order.created_at) }}</v-card-text>
    </v-card>


      <v-pagination
        v-model="page"
        :length="totalPages"
        prev-icon="mdi-menu-left"
        next-icon="mdi-menu-right"
      ></v-pagination>
    </v-container>

</template>

<script>
export default {
  components: {
  },
  data(){
    return {
      page: 1,
      totalPages: 1,
      orders: []
    }
  },
  async fetch(){
    try {
      const result = await this.$axios.$get('/api/user/order/list', {
        params: {
          page: this.page
        }
      })
      const {current_page, data, last_page} = result;
      this.page = current_page;
      this.totalPages = last_page;
      this.orders = data;
    }catch ( error ){
      if ('response' in error && error.response.status === 403) {
        return await this.$auth.logout();
      }
    }
  },
  methods: {
    formatDate(dateString){
      const date = new Date(dateString);

      return date.toLocaleDateString()
    }
  },
  watch: {
    'page': '$fetch',
    '$route.query': '$fetch'
  },
}
</script>


