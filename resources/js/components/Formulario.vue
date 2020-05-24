<template>
  <div v-if="value.attributes">
    <template v-for="(field,index) in fields">
      <div v-if="field.key==='attributes.avatar'" :key="`field-${index}`">
        <avatar v-model="value.attributes.avatar" style="font-size: 3em"></avatar>
        <div class="form-group">
          <div class="d-inline-block">
            <upload v-model="value.attributes.avatar" @change="updateAvatar">
              <button type="button" class="btn btn-primary">Cambiar imagen</button>
            </upload>
          </div>
        </div>
      </div>
      <b-form-group
        v-else-if="field.component" :key="`field-${index}`"
        :label="field.label"
        label-size="sm"
        :state="state"
        :invalid-feedback="feedback(field.key)"
      >
        <component :is="field.component" v-bind="field.properties" :value="getValue(value, field.key)" @change="setValue(value, field.key, $event)" />
      </b-form-group>
      <b-form-group
        v-else :key="`field-${index}`"
        :label="field.label"
        label-size="sm"
        :state="state"
        :invalid-feedback="feedback(field.key)"
      >
        <b-form-input class="form-control" :type="field.type || 'text'" :value="getValue(value, field.key)" @change="setValue(value, field.key, $event)" />
      </b-form-group>
    </template>
    <div class="text-right w-100 mt-2">
      <label class="text-danger" v-if="error">{{ error }}</label>
      <ul class="text-danger font-weight-light" v-for="(error, index) in errorsNotPresent" :key="`error-np-${index}`">
        <li v-for="(label, i) in error" :key="`error-np-${index}-${i}`">{{ label }}</li>
      </ul>
      <label class="text-success" v-if="success">{{ success }} <i class="fa fa-check"></i></label>
    </div>
  </div>
</template>

<script>
import { get, set } from 'lodash';

export default {
  mixins: [window.ResourceMixin],
  props: {
    value: Object,
    fields: Array,
    api: Object,
  },
  data() {
    return {
      state: null,
      errors: {},
      error: '',
      success: '',
    };
  },
  computed: {
    errorsNotPresent() {
      const errors = {};
      for(let e in this.errors) {
        if (!this.fields.find(field => field.key === e)) {
          errors[e] = this.errors[e];
        }
      }
      return errors;
    },
  },
  methods: {
    loadErrors(errors) {
      const loaded = {};
      if (errors) {
        for(let e in errors) {
          const a = `attributes.${e}`;
          loaded[a] = errors[e];
        }
      }
      this.$set(this, 'errors', loaded);
    },
    feedback(key) {
      const errors = this.errors;
      return errors[key];
    },
    updateAvatar(avatar) {
      this.value.attributes.avatar = avatar;
    },
    guardar() {
      return new Promise((accept, reject) => {
        this.success = '';
        this.state = null;
        if (this.value.id) {
          this.api.save(this.value).then((res) => {
            this.api.refresh(this.value);
            this.success = 'Los cambios se guardaron correctamente';
            this.state = true;
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res);
          });
        } else {
          this.api.post(this.value).then((res) => {
            this.success = 'Los cambios se guardaron correctamente';
            this.state = true;
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res);
          });
        }
      });
    },
    getValue(object, key) {
      return get(object, key);
    },
    setValue(object, key, value) {
      set(object, key, value);
    },
    setInputValue(object, key, event) {
      set(object, key, event.target.value);
    },
  },
}
</script>

<style>

</style>