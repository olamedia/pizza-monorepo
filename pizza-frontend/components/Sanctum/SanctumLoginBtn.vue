<template>
  <v-btn text v-if="!$store.state.auth.loggedIn" to="/login">
    <v-icon left>mdi-login</v-icon><slot />
  </v-btn>
</template>

<script>
export default {
  name: "SanctumLoginBtn"
}
</script>

<style scoped>

</style>
