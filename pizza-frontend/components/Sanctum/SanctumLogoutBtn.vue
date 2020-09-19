<template>
  <v-btn text v-if="$store.state.auth.loggedIn" @click="logout">
    <v-icon left>mdi-logout</v-icon><slot />
  </v-btn>
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
