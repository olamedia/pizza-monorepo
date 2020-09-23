<template>

  <span>
      <template v-if="!primary">{{ totalPrice.toFixed(2) }} {{ resultCurrency }}</template>
      <v-chip v-if="primary" dark label color="green" class="ml-1">
        {{ totalPrice.toFixed(2) }} {{ resultCurrency }}
      </v-chip>
  </span>

</template>

<script>


export default {
  name: "PriceChip",
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
    quantity: {
      type: Number,
      required: false,
      default: 1
    },
    currency: {
      type: String,
      required: true
    },
    targetCurrency: {
      type: String,
      required: true
    }
  },
  data(){
    return {
    }
  },
  async fetch(){
    await this.$store.dispatch('currency/loadCurrencyExchangeRates', this.$axios)
  },
  computed: {
    rates: {
      get() {
        return this.$store.state.currency.currencyRates
      }
    },
    resultRate(){
      if (this.currency === this.resultCurrency){
        return 1
      }
      if (this.rates === null){
        return 1;
      }
      return this.rates[this.currency] / this.rates[this.resultCurrency];
    },
    resultPrice(){
      return (this.price * this.resultRate).toPrecision(3);
    },
    totalPrice(){
      return this.resultPrice * this.quantity
    },
    resultCurrency(){
      if (this.rates === null){
        return this.currency;
      }
      return this.targetCurrency;
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
