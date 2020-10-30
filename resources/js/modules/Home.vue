<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-home"></i> {{ __('Home') }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <b-button @click="$bpmn.call('delivery.bpmn')">Nuevo pedido</b-button>
    <tabla ref="tasks" :fields="fields" :form-fields="formFields" :api="tasks" :title="__('Tasks')">
    </tabla>
  </panel>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin, window.WorkflowMixin],
  data() {
    return {
      tasks: this.$api.process_token,
      fields: [
        {key:'id', label: 'id'},
        {key:'attributes.name', label: 'Nombre'},
      ],
      formFields: [
        {key:'attributes.name', label: 'Nombre', create: true, edit: true },
      ],
    };
  },
  watch: {
    '$bpmn.NewProcess'() {
      this.$refs.tasks.loadData();
    },
  },
};
</script>
