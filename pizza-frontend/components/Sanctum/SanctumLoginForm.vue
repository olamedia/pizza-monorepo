<template>
  <v-container class="fill-height" fluid >
    <v-row align="center" justify="center">
      <v-card class="elevation-6 pa-6">
        <v-card-title>Login form
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-text-field
                v-model="login.email"
                :rules="[rules.required, rules.emailMatch]"
                label="E-Mail Address"
                required
              ></v-text-field>

            <v-text-field
              v-model="login.password"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required, rules.min]"
              :type="showPassword ? 'text' : 'password'"
              name="password"
              label="Password"
              hint="At least 8 characters"
              counter
              @click:append="showPassword = !showPassword"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="userLogin">Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-row>
  </v-container>

</template>

<script>

export default {
  name: "SanctumLoginForm",
  components: {},
  data(){
    return {
      login: {
        email: '',
        password: '',
      },
      showPassword: false,
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 3 || 'Min 3 characters',
        emailMatch: true,//() => ('The email and password you entered don\'t match'),
      },
    }
  },
  methods: {
    async userLogin() {
      this.$axios.$get('/api/sanctum/csrf-cookie').then(async(response) => {
        // Login...
        await this.$auth.loginWith('local', { data: this.login })
        // console.log(response)
      });
        // .then(() => this.$toast.success('Logged In!'))

      //     .then(() => this.$toast.success('Logged In!'))
      // try {
      //   this.$axios.defaults.xsrfHeaderName
      //   const token = await this.$axios.$post('/api/auth/login', this.login);
      //   this.$auth.setUser(user);
      //   // console.log(response)
      // } catch (err) {
      //   console.log(err)
      // }
    },
  }
}
</script>

<style scoped>

</style>
