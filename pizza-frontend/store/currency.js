export const state =() => ({
  currentCurrency: 'USD',
  currencyRates: null,
  ratesLoading: false,
  ratesLoaded: false
})

export const mutations = {
  setCurrencyExchangeRates(state, rates){
    console.log(rates)
    state.currencyRates = rates;
    state.ratesLoaded = true;
  },
  setLoadingCurrencyExchangeRates(state){
    state.ratesLoading = true;
  },
  setCurrency(state, currency){
    state.currentCurrency = currency;
  }
}

export const actions = {
  async loadCurrencyExchangeRates({ commit, state }, $axios) {
    if (state.ratesLoading || state.ratesLoaded){
      return
    }
    console.log('loadCurrencyExchangeRates start')
    await commit('setLoadingCurrencyExchangeRates');
    const rates = await $axios.$get('/api/currency');
    console.log('loadCurrencyExchangeRates rates', rates)
    commit('setCurrencyExchangeRates', rates);

    return state.currencyRates
  }

}
