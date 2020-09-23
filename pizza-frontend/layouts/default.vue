<template>
  <v-app>
    <v-app-bar app dense elevate-on-scroll>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>Pizza</v-toolbar-title>

      <v-spacer></v-spacer>

      <client-only>
        <SanctumLoginBtn>Login</SanctumLoginBtn>
        <SanctumLogoutBtn>Log out</SanctumLogoutBtn>
      </client-only>

      <template v-slot:extension>
        <AppTabs></AppTabs>
      </template>

    </v-app-bar>
    <v-main>
      <v-container fluid>
        <nuxt/>
      </v-container>
    </v-main>
  </v-app>
</template>


<style>
html {
  font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  font-size: 16px;
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: border-box;
  margin: 0;
}
</style>

<script>
import SanctumLoginBtn from "~/components/Sanctum/SanctumLoginBtn";
import SanctumLogoutBtn from "~/components/Sanctum/SanctumLogoutBtn";
import CartBadge from "@/components/CartBadge";
import OrdersBadge from "~/components/OrdersBadge";
import AppTabs from "~/components/AppTabs";

export default {
  components: {AppTabs, OrdersBadge, CartBadge, SanctumLogoutBtn, SanctumLoginBtn},

}
</script>
