<template>
  <ul class="list-group">
    <template v-for="(item, index) in items(0)">
      <li class="list-group-item level-1">
        <slot :item="item" :control="status[index]"></slot>
      </li>
      <template v-if="status[index].status.open" v-for="item in items(item.id)">
        <li class="list-group-item level-2">
          <slot :item="item" :control="status[indexItem(item)]"></slot>
        </li>
        <template v-if="status[indexItem(item)].status.open" v-for="item in items(item.id)">
          <li class="list-group-item level-3">
            <slot :item="item" :control="status[indexItem(item)]"></slot>
          </li>
          <template v-if="status[indexItem(item)].status.open" v-for="item in items(item.id)">
            <li class="list-group-item level-4">
              <slot :item="item" :control="status[indexItem(item)]"></slot>
            </li>
          </template>
        </template>
      </template>
    </template>
  </ul>
</template>

<script>
function NodeControl(item)
{
    this.item = item;
    this.status = {
        open: true,
    };
}
NodeControl.prototype.close = function () {
    this.status.open = false;
};
NodeControl.prototype.open = function () {
    this.status.open = open;
};
NodeControl.prototype.toggle = function () {
    this.status.open = !this.status.open;
};
export default {
  props: {
    value: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      status: []
    };
  },
  watch: {
    value: {
      immediate: true,
      handler() {
        this.status.splice(0);
        this.value.forEach(element => {
          this.status.push(new NodeControl(element));
        });
      }
    }
  },
  methods: {
    indexItem (item) {
      return this.value.indexOf(item);
    },
    items(id) {
      return this.value.filter(item => item.parent === id);
    }
  }
};
</script>

<style scoped>
.level-1 {
  padding-left: 1em;
}
.level-2 {
  padding-left: 2em;
}
.level-3 {
  padding-left: 3em;
}
.level-4 {
  padding-left: 4em;
}
</style>
