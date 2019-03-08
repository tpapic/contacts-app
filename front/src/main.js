import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'

import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'

Vue.use(VueRouter)

Vue.use(BootstrapVue)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.config.productionTip = false

axios.interceptors.response.use(response => {
  return response;
}, error => {
  if (error.response.status === 401) {
    store.dispatch('logout')
    router.go('/login')
  }
  return error;
});

window.axios = axios
axios.defaults.baseURL = 'http://localhost:8000/api'

/* Authorization token was removed after refresh page */
if (typeof axios.defaults.headers.common['Authorization'] === 'undefined') {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.getToken
}

const guestRoutes = [
  'Login'
]

router.beforeEach((to, from, next) => {
  let isUserAuthenticated = store.getters.isUserAuthenticated
  if (guestRoutes.indexOf(to.name) !== -1) {
    next()
  } else if (to.path !== '/login' && !isUserAuthenticated) {
    next('login')
  } else {
    next()
  }
})

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#app')
