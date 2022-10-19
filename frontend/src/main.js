import Vue from "vue";
import App from "./App.vue";

import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import Vuelidate from "vuelidate";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import axios from "axios";
axios.defaults.baseURL = process.env.VUE_APP_API_URL;
export default axios;

Vue.use(VueSweetalert2);
Vue.config.productionTip = false;
Vue.use(Vuelidate);

Vue.prototype.$axios = axios;

new Vue({
  render: (h) => h(App),
}).$mount("#app");
