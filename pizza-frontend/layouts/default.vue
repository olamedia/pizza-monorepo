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
        <v-tabs align-with-title>
          <v-tab to="/" exact>Меню</v-tab>
          <v-tab to="/cart">
            <v-badge
              inline
              color="warning"
              content="6"
              overlap
            >
              Корзина
            </v-badge>
          </v-tab>
          <v-tab to="/orders">
            <v-badge
              inline
              color="warning"
              content="6"
              overlap
            >
              Заказы
            </v-badge>
          </v-tab>
        </v-tabs>
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

.button--green {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #3b8070;
  color: #3b8070;
  text-decoration: none;
  padding: 10px 30px;
}

.button--green:hover {
  color: #fff;
  background-color: #3b8070;
}

.button--grey {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #35495e;
  color: #35495e;
  text-decoration: none;
  padding: 10px 30px;
  margin-left: 15px;
}

.button--grey:hover {
  color: #fff;
  background-color: #35495e;
}
</style>

<script>
import SanctumLoginBtn from "~/components/Sanctum/SanctumLoginBtn";
import SanctumLogoutBtn from "~/components/Sanctum/SanctumLogoutBtn";
export default {
  components: {SanctumLogoutBtn, SanctumLoginBtn}
}
</script>
