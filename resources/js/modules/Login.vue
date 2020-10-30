<template>
  <background>
    <middle content-class="p-3">
      <b-row>
        <b-col cols="12">
          <h1 class="title text-white text-border-black">{{app_name}}</h1>
        </b-col>
        <b-col cols="12" sm="6">
          <b-form-group
            label-for="username"
          >
            <b-form-input
              id="username"
              v-model="username"
              required
              :placeholder="__('user')"
            ></b-form-input>
          </b-form-group>
          <b-form-group
            label-for="password"
          >
            <b-form-input
              id="password"
              v-model="password"
              required
              type="password"
              :placeholder="__('password')"
            ></b-form-input>
          </b-form-group>
          <b-button class="w-100" type="button" variant="primary" @click="login">{{ __('Login') }}</b-button>
        </b-col>
        <b-col>
          <b-button
            v-for="provider in providers"
            :key="`provider-${provider.key}`"
            class="text-white mt-2 w-100"
            :style="`background: ${provider.background};`"
            :href="provider.url"
            target="login"
          >
            {{ __('Login with') }} <i :class="provider.icon"></i>
          </b-button>
        </b-col>
      </b-row>
    </middle>
  </background>
</template>

<script>
export default {
  path: '/login',
  data() {
    return {
      username: '',
      password: '',
      listener: null,
      providers: global.config.providers,
    };
  },
  methods: {
    login() {
      window.axios.post(`${global.config.VUE_APP_SERVER_URL}/oauth/token`, {
        grant_type: 'password',
        client_id: global.config.client_id,
        client_secret: global.config.client_secret,
        username: this.username,
        password: this.password,
        scope: '*',
      }).then(response => {
        this.$root.login({token: response.data.access_token});
      }).catch(() => this.error = this.__('Invalid user or password'));
    },
  },
  mounted() {
      this.listener = window.addEventListener('message', (event) => {
        if (event.data.user && event.data.broadcaster) {
          this.$root.login(event.data);
        }
      }, false);
  },
  destroyed() {
    window.removeEventListener('message', this.listener);
  },
}
</script>

<style scoped>
.title {
  font-family: 'Logo', 'Nunito', sans-serif;
}
</style>
