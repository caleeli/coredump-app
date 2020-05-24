<template>
  <div class="d-flex ml-2">
    <div class="btn-group text-nowrap mr-2" role="group">
      <slot />
      <router-link to="/" class="btn btn-warning"><i class="fas fa-home"></i> Inicio</router-link>
      <router-link v-if="$root.isAdmin" to="/usuarios" class="btn btn-info"><i class="fas fa-users"></i> Usuarios</router-link>
    </div>
    <b-button class="mr-2" :variant="isEnabled() ? 'primary' : 'outline-primary'" @click="requestNotificationAccess">
      <i v-if="isEnabled()" class="fas fa-bell"></i>
      <i v-else class="fas fa-bell-slash"></i>
    </b-button>
    <div class="btn-group" role="group">
      <router-link v-if="$root.user.attributes" to="/perfil" class="btn btn-outline-secondary text-nowrap pr-4">
        {{ $root.user.attributes.name }} <avatar v-model="$root.user" style="font-size: 1.5em;position: absolute;" />
      </router-link>
      <a href="/logout" class="btn btn-outline-danger text-nowrap">
        <i class="fas fa-power-off"></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      notificationRequest: Notification.permission,
      enableNotifications: window.localStorage.enableNotifications,
    };
  },
  methods: {
    isEnabled() {
      return this.enableNotifications && this.notificationRequest;
    },
    requestNotificationAccess() {
      if (this.isEnabled()) {
        window.localStorage.enableNotifications = '';
      } else {
        window.localStorage.enableNotifications = '1';
      }
      this.enableNotifications = window.localStorage.enableNotifications;
      Vue.notification.requestPermission().then(() => {
        this.notificationRequest = Notification.permission;
      });
    },
  },
}
</script>

<style>

</style>