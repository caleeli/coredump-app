<template>
  <span v-if="!isApp">
      <img class="logo" :src="logo">
  </span>
  <b-dropdown v-else
    class=""
    variant="link"
    toggle-class="text-decoration-none ml-n4 mt-n3 mb-n3 p-3"
    no-caret
  >
    <template #button-content>
      <img class="logo" :src="logo">
    </template>
      <b-dropdown-item-button to="/">
        <i class="fas fa-home"></i> {{ __('Home') }}
      </b-dropdown-item-button>
      <b-dropdown-item-button>
        <router-link v-for="menu in $root.menus" :key="`menu-${menu.id}`"
          :to="menu.path"><i :class="menu.icon"></i> {{ __(menu.name) }}</router-link>
      </b-dropdown-item-button>
  </b-dropdown>
</template>

<script>
import NavBar from './NavBar';
import logo from '../../images/logo.svg';

export default {
  extends: NavBar,
  data() {
    return {
      logo
    }
  },
}
</script>

<style>
.logo {
  height: 2em;
}
</style>