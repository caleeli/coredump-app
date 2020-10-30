//import Ionic from '@ionic/vue';
import Vue from 'vue'
import { BootstrapVue } from 'bootstrap-vue';
import VueFontAwesomePicker from "vfa-picker";
import moment from 'moment';
import Echo from 'laravel-echo';
import VueJddComponents from 'vue-jdd-components';
import VueRouter from 'vue-router';
import trans from './mixins/trans';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import '../sass/app.scss';

window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Vue = Vue;
window.moment = moment;
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = process.env.VUE_APP_SERVER_URL + '/api/data/';
window.io = require('socket.io-client');
const config = JSON.parse(process.env.VUE_APP_CONFIG);
config.VUE_APP_SERVER_URL = process.env.VUE_APP_SERVER_URL;
global.config = config;
window._config = config;
window._translations = config.translations;
window._locale = config.locale;
window.userId = null;

//Vue.use(Ionic);
Vue.use(VueFontAwesomePicker);
Vue.use(VueJddComponents, { jQuery: window.$ });
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.mixin(trans);
Vue.config.productionTip = false;
Vue.mixin({data(){ return {isApp: true, app_name: config.name }}});

window.router = new VueRouter({
    routes: []
});

// components
const files = require.context('./components/', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// modules
const modules = require.context('./modules/', true, /\.vue$/i);
modules.keys().map(key => {
    const component = modules(key).default;
    const name = key.split('/').pop().split('.')[0];
    const path = component.path ? component.path : name;
    Vue.component(name, component);
    window.router.addRoutes([{ name: component.name || name, path, component, props: true }]);
});

// Go to login if not logged
if (!window.userId) {
    window.router.replace('/login');
}

new Vue({
    router: window.router,
    el: '#app',
    mixins: [window.ResourceMixin],
    data() {
        return {
            menus: [],
            me: this,
            user: {},
        };
    },
    computed: {
        isAdmin() {
            return this.user.id === 1;
        },
    },
    methods: {
        login(data) {
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`;
            const token = data.token;
            if (!data.user) {
                window.axios.get(`${global.config.VUE_APP_SERVER_URL}/oauth/userinfo`)
                .then(({data}) => {
                    window.userId = data.user.id;
                    this.user = data.user;
                    this.menus = data.menus;
                    window.Echo = new Echo(Object.assign(data.broadcaster, {
                        auth: {
                            headers: {
                                Authorization: 'Bearer ' + token,
                            },
                        },
                    }));
                    this.$router.push('/');
                });
            } else {
                window.userId = data.user.id;
                this.user = data.user;
                this.menus = data.menus;
                window.Echo = new Echo(Object.assign(data.broadcaster, {
                    auth: {
                        headers: {
                            Authorization: 'Bearer ' + token,
                        },
                    },
                }));
                this.$router.push('/');
            }
        },
    },
});
