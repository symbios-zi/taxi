import Vue from 'vue';
import App from './components/app.vue';
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import './filters/MoneyFilter.js';
import './filters/KilometerFilter.js';
import './filters/TimeFilter.js';


Vue.use(BootstrapVue);

Vue.config.debug = true;
Vue.config.devtools = true;

new Vue(Vue.util.extend(App)).$mount('app');