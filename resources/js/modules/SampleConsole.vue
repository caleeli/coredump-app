<template>
  <panel name="Console" icon="fa fa-user" class="panel-success">
    <pre>{{log}}</pre>
  </panel>
</template>

<script>
export default {
  path: "/sample/console",
  mixins: [window.workflowMixin],
  data() {
    return {
      log: ""
    };
  },
  watch: {
    "$route.query": {
      immediate: true,
      deep: true,
      handler() {
        this.cleanSocketListeners();
        this.listenConsole(log => {
          window.axios
            .get(log.url, { baseURL: "/" })
            .then(response => (this.log = response.data));
        });
      }
    }
  }
};
</script>
