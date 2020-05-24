<template>
  <panel name="Usuarios" class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-users"></i> Usuarios
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <tabla :fields="fields" :form-fields="formFields" :api="api" title="Usuario"
      :search-in="['attributes.name', 'attributes.email']"
    >
      <template v-slot:actions="data">
        <b-button v-b-modal.changePassword @click="editar(data.item)" variant="info"><i class="fas fa-key"></i></b-button>
      </template>
    </tabla>
    <b-modal id="changePassword"
      @ok="guardar"
      title="Cambiar contraseña"
    >
      <formulario ref="formulario" :value="user" :fields="changePasswordFields" :api="api">
      </formulario>
      <template slot="modal-ok">
        <i class="fas fa-save"></i> Guardar
      </template>
      <template slot="modal-cancel">
        <i class="fas fa-window-close"></i> Cancelar
      </template>
    </b-modal>
  </panel>
</template>

<script>
export default {
  name: "Usuarios",
  path: "/users",
  mixins: [window.ResourceMixin],
  data() {
    return {
      user: {},
      api: this.$api.user,
      fields: [
        {key:'id', label: 'id'},
        {key:'attributes.avatar', label: ''},
        {key:'attributes.name', label: 'Nombre'},
        {key:'attributes.email', type: 'email', label: 'Correo'},
        {key:'attributes.role', label: 'Rol'},
        {key:'actions', label: ''},
      ],
      formFields: [
        {key:'attributes.avatar', label: '', create: true, edit: true },
        {key:'attributes.name', label: 'Nombre', create: true, edit: true },
        {key:'attributes.email', label: 'Correo', type: 'email', create: true, edit: true },
        {key:'attributes.password', label: 'Contraseña', type: 'password', create: true, edit: false },
        {key:'attributes.role', label: 'Rol', create: true, edit: true, component: 'b-select', properties: {
            options: ["admin", "operator"]
          }
        },
      ],
      changePasswordFields: [
        {key:'attributes.password', label: 'Contraseña', type: 'password' },
        {key:'confirm_password', label: 'Confirmar contraseña', type: 'password' },
      ],
    };
  },
  methods: {
    editar(user) {
      this.user = user;
    },
    guardar(event) {
      if (this.user.confirm_password !== this.user.attributes.password) {
        this.$refs.formulario.error = 'Contraseñas no coinciden';
        event.preventDefault();
      } else {
        this.$refs.formulario.guardar();
      }
    },
  },
};
</script>

<style scoped>
</style>
