<template>
  <PriceChipInCurrentCurrency primary :price="totalPrice" :currency="currency"></PriceChipInCurrentCurrency>
</template>

<script>
import PriceChipInCurrentCurrency from "~/components/PriceChipInCurrentCurrency";
export default {
  name: "TotalPriceChip",
  components: {PriceChipInCurrentCurrency},
  props: {
    items: {
      type: Array,
      required: true,
    }
  },
  methods: {
    productResultRate(item){
      if (item.currency === this.currency){
        return 1
      }
      if (this.rates === null){
        return 1;
      }
      return this.rates[item.currency] / this.rates[this.currency];
    },
    productResultPrice(item){
      const rate = this.productResultRate(item);
      console.log(rate + ` from ${item.currency} to ${this.currency}`)
      return (item.price * rate).toPrecision(2);
    },
    itemTotalPrice(item){
      return this.productResultPrice(item) * item.quantity
    }
  },
  computed: {
    currency() {
      return this.$store.state.currency.currentCurrency
    },
    rates(){
      return this.$store.state.currency.currencyRates
    },
    totalPrice(){
      if (this.rates === null){
        return null
      }
      return this.items.map(item => {
        const price = this.itemTotalPrice(item);
        console.log(item, price)
        return price
      }).reduce((accumulator, itemTotalPrice) => {
        console.log(itemTotalPrice)
        accumulator = accumulator + itemTotalPrice
        return accumulator
      }, 0);
    }
  }

}
</script>

<style scoped>

</style>
