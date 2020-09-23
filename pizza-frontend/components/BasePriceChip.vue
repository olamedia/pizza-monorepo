<template>

  <span>
      <template v-if="!primary">{{ price.toFixed(2) }} {{ currency }}</template>
      <v-chip v-if="primary" dark label color="green" class="ml-1">
        {{ price.toFixed(2) }} {{ currency }}
      </v-chip>
  </span>

</template>

<script>

export default {
  name: "BasePriceChip",
  components: {},
  props: {
    primary: {
      type: Boolean,
      required: false,
      default: false
    },
    price: {
      type: Number,
      required: true
    },
    currency: {
      type: String,
      required: true
    }
  },
}
</script>

<style scoped>
span{
  display: inline-block;
  vertical-align: middle;
}
</style>
