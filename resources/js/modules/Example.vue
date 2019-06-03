<template>
  <panel name="Example" icon="fa fa-user" class="panel-success">
    <datetime v-model="today"></datetime>
    <button class="btn btn-primary" @click="callProcess('sample.bpmn')">Start Process</button>
  </panel>
</template>

<script>
export default {
  path: "/",
  mixins: [window.workflowMixin],
  data() {
    return {
      today: window.moment().format()
    };
  }
};
</script>
