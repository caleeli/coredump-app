<template>
  <div>
    <img class="logo" :src="logo"> {{ $root.$route.name }}
  </div>
</template>

<script>
import logo from '../../images/logo.png';

export default {
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