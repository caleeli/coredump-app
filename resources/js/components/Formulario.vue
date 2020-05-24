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
      <div v-else-if="field.component" :key="`field-${index}`">
        <small>{{ field.label }}</small>
        <component :is="field.component" v-bind="field.properties" :value="getValue(value, field.key)" @change="setValue(value, field.key, $event)" />
      </div>
      <div v-else :key="`field-${index}`">
        <small>{{ field.label }}</small>
        <input class="form-control" :type="field.type || 'text'" :value="getValue(value, field.key)" @input="setInputValue(value, field.key, $event)">
      </div>
    </template>
    <div class="text-right w-100 mt-2">
      <label class="text-danger" v-if="error">{{ error }}</label>
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
  computed: {
  },
  data() {
    return {
      error: '',
      success: '',
    };
  },
  methods: {
    updateAvatar(avatar) {
      this.value.attributes.avatar = avatar;
    },
    guardar() {
      return new Promise((accept, reject) => {
        this.success = '';
        if (this.value.id) {
          this.api.save(this.value).then((res) => {
            this.api.refresh(this.value);
            this.success = 'Los cambios se guardaron correctamente';
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
            reject(res);
          });
        } else {
          this.api.post(this.value).then((res) => {
            this.api.refresh(this.value);
            this.success = 'Los cambios se guardaron correctamente';
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
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