<template>
  <v-btn v-if="$store.state.auth.loggedIn" @click="logout"><slot /></v-btn>
</template>

<script>
export default {
  name: "SanctumLogoutBtn",
  methods: {
    async logout(){
      await this.$auth.logout('local')
    }
  }
}
</script>

<style scoped>

</style>
