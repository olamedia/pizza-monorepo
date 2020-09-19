<template>
  <v-btn v-if="!$store.state.auth.loggedIn" text to="/login">
    <slot />
  </v-btn>
</template>

<script>
export default {
  name: "SanctumLoginBtn"
}
</script>

<style scoped>

</style>
