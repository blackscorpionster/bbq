import Vue from 'vue';
import App from './App.vue';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import {LayoutPlugin} from 'bootstrap-vue';
import {NavbarPlugin} from 'bootstrap-vue';
import {CollapsePlugin} from 'bootstrap-vue';
import LoadScript from 'vue-plugin-load-script';
import { ToastPlugin } from 'bootstrap-vue'

Vue.config.productionTip = false;
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(LayoutPlugin);
Vue.use(NavbarPlugin);
Vue.use(CollapsePlugin);
Vue.use(LoadScript);
Vue.use(ToastPlugin)

new Vue({
  render: h => h(App),
}).$mount('#app');
