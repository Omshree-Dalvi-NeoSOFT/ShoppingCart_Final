import Vue from 'vue'
import App from './App.vue'
import router from './Router'
import Vuelidate from 'vuelidate'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

Vue.config.productionTip = false
Vue.use(Vuelidate)

new Vue({
  router,
  store,
  mode: "history",
  render: h => h(App),
}).$mount('#app')
