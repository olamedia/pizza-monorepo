export const state =() => ({
  items: [],
})

export const getters = {
  totalItemsNumber: state => {
    return state.items.reduce((sum, item) => {
      return sum + item.quantity;
    }, 0)
  }
}

export const mutations = {
  async clearCart(state){
    state.items = []
  },
  mergeBackendItems(state, backendItems){
    console.log({backendItems})
    backendItems.forEach(backendItem => {
      const cartItem = state.items.find(item => {
        return backendItem.product.id === item.product.id;
      })
      if (typeof cartItem !== 'undefined'){
        // Current behavior is to use quantity from frontend
        // cartItem.quantity = backendItem.quantity
        return
      }
      state.items.push(backendItem);
    });
  },
  setProductQuantity(state, {productId, quantity}){
    const cartItem = state.items.find(item => {
      return productId === item.product.id;
    })
    if (typeof cartItem !== 'undefined'){
      cartItem.quantity = quantity
    }
  },
  removeProduct(state, productId){
    state.items = state.items.filter(item => {
      return productId !== item.product.id;
    })
  },
  addProduct(state, {product, quantity}){
    state.items.push({
      product,
      quantity
    });
  }
}

export const actions = {
  async saveUserCart({ commit, state }, $axios){
    try{
      const result = await $axios.$post('/api/user/cart', { items: state.items })
    }catch ( error ){
      if ('response' in error && error.response.status === 403) {
        // return await this.$auth.logout();
      }
    }
  },
  async loadUserCart({ commit, state }, $axios){
    try{
      const result = await $axios.$get('/api/user/cart')
      const backendItems = result.items.map(resultItem => {
        const product = result.products.find(product => {
          return resultItem.product_id === product.id;
        })
        return {
          quantity: resultItem.quantity,
          product
        }
      });
      commit('mergeBackendItems', backendItems)
    }catch ( error ){
      if ('response' in error && error.response.status === 403) {
        // return await this.$auth.logout();
      }
    }
  },
  setProductQuantity({ commit, state }, {productId, quantity}){
    if (quantity > 0){
      commit('setProductQuantity', {productId, quantity})
    }else{
      commit('removeProduct', productId)
    }
  },
  addProduct({ commit, state, dispatch }, {product, quantity}){
    console.log('cart/addProduct', product, quantity)
    const cartItem = state.items.find(item => {
      return product.id === item.product.id;
    })
    if (typeof cartItem !== 'undefined'){
      const newQuantity = cartItem.quantity + quantity
      dispatch('setProductQuantity', {productId: product.id, quantity: newQuantity})

      return
    }
    if (quantity > 0) {
      commit('addProduct', {
        product,
        quantity
      })
    }
  },
}
