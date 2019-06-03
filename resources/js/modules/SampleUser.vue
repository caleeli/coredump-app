<template>
  <panel name="Crear usuario" icon="fa fa-user" class="panel-success">
    <div class="m-t">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Name" v-model="user.name" required>
      </div>
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Email" v-model="user.email" required>
      </div>
      <div class="form-group">
        <input
          type="password"
          class="form-control"
          placeholder="Password"
          v-model="user.password"
          required
        >
      </div>
      <button
        type="submit"
        class="btn btn-primary block full-width m-b"
        @click="completeTask({user})"
      >Siguiente</button>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/sample/user",
  mixins: [window.workflowMixin],
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: ""
      }
    };
  }
};
</script>
