<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <slot name="logo"></slot>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <template v-for="menu in menus(0)">
          <li v-if="menu.route==='#'" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{menu.name}}</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link
                v-for="submenu in menus(menu.id)"
                v-bind:key="submenu.id"
                class="dropdown-item"
                :to="submenu.route"
              >{{submenu.name}}</router-link>
            </div>
          </li>
          <li v-else class="nav-item">
            <router-link class="nav-link" :to="menu.route">{{menu.name}}</router-link>
          </li>
        </template>
      </ul>
      <slot name="right"></slot>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    value: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  computed: {
    csrfToken() {
      let tag = document.head.querySelector('meta[name="csrf-token"]');
      return tag ? tag.content : null;
    }
  },
  methods: {
    menus(id) {
      return this.value.filter(item => item.parent === id);
    }
  }
};
</script>
