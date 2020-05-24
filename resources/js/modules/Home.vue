<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-home"></i> Inicio
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
  </panel>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
    };
  }
};
</script>
