import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    token: null,
    user: null
  },
  getters: {
    getUser(state) { return state.user },
    getToken(state) { return state.token },
    getUserActions(state) {
      if (state.user && state.user.actions) {
        return state.user.actions
      }

      return null
    },
    isUserAuthenticated(state) {
      if (state.user) {
        return true
      }

      return false
    },
    isUserAdmin(state) {
      if (state.user && state.user.role && state.user.role.name === 'Admin') {
        return true
      }

      return false
    },
    userPermissionCheck: (state, getters) => (findAction) => {
      if (state.user && state.user.actions) {
        if (!findAction) {
          // if findAction not provided default menu item is not active
          return false
        }
        let actions = state.user.actions
        let data = actions.find(action => action.name === findAction)
        if (data) {
          return true
        }
        return false
      }
    }
  },
  mutations: {
    setToken(state, token) {
      state.token = token
    },
    setUser(state, user) {
      state.user = user
    },
    setGlobalToken(state) {
      if (state.token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.token
      } else {
        delete axios.defaults.headers.common['Authorization']
      }
    }
  },
  actions: {
    setUser(context, response) {
      context.commit('setUser', response.data.user)
      context.commit('setToken', response.data.token)
      context.commit('setGlobalToken')
    },
    logout(context) {
      context.commit('setUser', null)
      context.commit('setToken', null)
      context.commit('setGlobalToken')
    }
  },
  plugins: [createPersistedState({ storage: window.sessionStorage })],
  strict: debug
})
