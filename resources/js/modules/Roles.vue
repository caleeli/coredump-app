<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fas fa-user-tie"></i> {{ __('Roles') }} - {{ __('Menus') }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <b-tabs v-model="tab" card class="m-n4">
      <b-tab v-for="role in roles"
        :key="`role-${role.id}`"
        :title="role.attributes.role"
      >
        <role :role="role" />
      </b-tab>
    </b-tabs>
  </panel>
</template>

<script>
export default {
  path: "/roles",
  mixins: [window.ResourceMixin],
  data() {
    return {
      tab: 0,
      roles: this.$api.roles.array({per_page: -1}),
    };
  },
  methods: {
  },
};
</script>

<style scoped>
</style>
