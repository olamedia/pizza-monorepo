<template>
  <v-badge v-if="cartItemsNumber" inline :color="cartItemsNumber ? 'warning' : ''" :content="cartItemsNumber" overlap>
  </v-badge>
</template>

<script>
export default {
  name: "CartBadge",
  computed: {
    cartItemsNumber(){
      return this.$store.getters["cart/totalItemsNumber"]
    }
  }
}
</script>

<style scoped>

</style>
