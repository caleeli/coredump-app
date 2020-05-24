<template>
  <div>
    <div class="d-flex">
      <b-input-group :class="{invisible: !searchIn}">
        <b-form-input :lazy="true" v-model="searchValue" size="sm" @change="search"></b-form-input>
        <b-input-group-append>
          <b-button variant="outline-secondary" @click="search">Buscar</b-button>
        </b-input-group-append>
      </b-input-group>
      <b-input-group v-if="params.per_page!==-1" style="width: 22em;">
        <b-input-group-prepend>
          <b-button variant="outline-secondary" :disabled="params.page<=1" @click="setPage(1)"><i class="fas fa-step-backward"></i></b-button>
          <b-button variant="outline-secondary" :disabled="params.page<=1" @click="setPage(params.page - 1)"><i class="fas fa-caret-left"></i></b-button>
        </b-input-group-prepend>
        <b-form-input v-model="page" :lazy="true" class="text-right" size="sm"></b-form-input>
        <b-input-group-append>
          <b-button variant="outline-secondary" disabled>/{{ meta.last_page }}</b-button>
          <b-button variant="outline-secondary" :disabled="params.page>=meta.last_page" @click="setPage(params.page + 1)"><i class="fas fa-caret-right"></i></b-button>
          <b-button variant="outline-secondary" :disabled="params.page>=meta.last_page" @click="setPage(meta.last_page)"><i class="fas fa-step-forward"></i></b-button>
        </b-input-group-append>
      </b-input-group>
    </div>
    <b-table :items="value" :fields="fields">
      <template v-slot:cell()="data">
        <slot v-if="hasSlot(`cell(${data.field.key})`)" :name="`cell(${data.field.key})`" v-bind="data" :update="update"></slot>
        <template v-else>
          {{ getValue(data.item, data.field.key) }}
        </template>
      </template>
      <template v-slot:cell(attributes.avatar)="data">
        <avatar style="font-size: 2em" :value="data.item.attributes.avatar" />
      </template>
      <template v-slot:head(actions)="">
        <div class="w-100 text-right">
          <b-button variant="primary" @click="nuevo"><i class="fas fa-plus"></i> NUEVO</b-button>
        </div>
      </template>
      <template v-slot:cell(actions)="data">
        <div class="w-100 text-right">
          <div class="btn-group text-nowrap" role="group">
            <slot name="actions" v-bind="data"></slot>
            <b-button variant="primary" @click="editar(data.item)"><i class="fas fa-pen"></i></b-button>
            <b-button variant="danger" @click="eliminar(data.item)"><i class="fas fa-times"></i></b-button>
          </div>
        </div>
      </template>
    </b-table>
    <b-modal
      ref="modal"
      :title="title"
      @ok="guardar"
    >
      <formulario ref="formulario" :fields="formFieldsF" :value="registro" :api="api" />
      <template slot="modal-ok">
        <i class="fas fa-save"></i> Guardar
      </template>
      <template slot="modal-cancel">
        <i class="fas fa-window-close"></i> Cancelar
      </template>
    </b-modal>
  </div>
</template>

<script>
import { get, set } from 'lodash';

const nuevoRegistro = {
  id: null,
  attributes: {},
};
export default {
  mixins: [window.ResourceMixin],
  props: {
    inlineAdd: {
      type: Boolean,
      default: false,
    },
    params: {
      type: Object,
      default() {
        return {
          page: 1,
          per_page: 25,
          meta: "pagination",
        };
      },
    },
    searchIn: Array,
    fields: Array,
    formFields: Array,
    api: Object,
    title: String,
  },
  computed: {
    formFieldsF() {
      return this.formFields.filter(field => {
        return (!this.registro.id && (field.create)) || 
          (this.registro.id && (field.edit));
      });
    }
  },
  data() {
    return {
      searchValue: '',
      value: [],
      meta: {
        total: 0,
        last_page: 0,
      },
      page: this.params.page || 1,
      registro: nuevoRegistro,
      error: '',
    };
  },
  methods: {
    update(row) {
      this.api.save(row).catch(res => {
        this.error = res.response.data.message;
      }).then(() => {
        this.loadData();
      });
    },
    hasSlot(name) {
      return !!this.$scopedSlots[name];
    },
    search() {
      if (this.searchIn) {
        const filter = `whereAjaxFilter,${JSON.stringify(this.searchValue)},${this.searchIn.join(',')}`;
        if (this.params.filter === undefined) {
          this.params.filter = [];
        }
        const index = this.params.filter.findIndex(filter => filter.substr(0, 16) === 'whereAjaxFilter,');
        if (index === -1) {
          this.params.filter.push(filter);
        } else {
          this.params.filter[index] = filter;
        }
        this.setPage(1);
      }
    },
    setPage(page) {
      this.params.page = page;
      this.loadData();
    },
    eliminar(registro) {
      this.api.delete(registro).catch(res => {
        alert(res.response.data.message);
      }).then(() => {
        this.loadData();
      });
    },
    editar(registro) {
      this.error = '';
      this.registro = registro;
      this.$refs.modal.show();
    },
    updateAvatar(avatar) {
      this.registro.attributes.avatar = avatar;
    },
    guardar(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.$refs.formulario.guardar().then(() => {
        this.$refs.modal.hide();
        this.loadData();
      });
      /*if (this.registro.id) {
        this.api.put(this.registro).then((res) => {
          this.$refs.modal.hide();
          this.loadData();
        }).catch(res => {
          this.error = res.response.data.message;
        });
      } else {
        this.api.post(this.registro).then(() => {
          this.$refs.modal.hide();
          this.loadData();
        }).catch(res => {
          this.error = res.response.data.message;
        });
      }*/
    },
    getValue(object, key) {
      return get(object, key);
    },
    setValue(object, key, event) {
      set(object, key, event.target.value);
    },
    nuevo() {
      this.error = '';
      if (this.inlineAdd) {
        this.value.push(nuevoRegistro);
      } else {
        this.registro = nuevoRegistro;
        this.$refs.modal.show();
      }
    },
    loadData() {
      this.api.index(this.params, this.value).then(response => {
        this.meta = response.data.meta;
      });
    },
  },
  mounted() {
    this.loadData(); 
  },
  watch: {
    page(page) {
      this.setPage(page);
    }
  },
}
</script>

<style>

</style>