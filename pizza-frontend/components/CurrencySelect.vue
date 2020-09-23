<template>
  <v-select
    v-model="currency.selected"
    :items="items"
    item-text="label"
    item-value="value"
    label="Валюта"
  ></v-select>
</template>

<script>
export default {
  name: "CurrencySelect",
  data(){
    const currency = {};
    Object.defineProperty(currency, 'selected', {
      get: () => {
        return this.$store.state.currency.currentCurrency;
      },
      set: (value) => {
        this.$store.commit('currency/setCurrency', value)
      }
    })

    return {
      currency,
      // select: { value: 'USD', label: 'USD' },
      items: [
        { value: 'USD', label: 'USD' },
        { value: 'EUR', label: 'EUR' }
      ]
    }
  }
}
</script>

<style scoped>

</style>
