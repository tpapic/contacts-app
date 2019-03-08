import Vue from 'vue'
import Router from 'vue-router'

// Views
import Contacts from '@/views/contacts/Contacts'
import ContactAdd from '@/views/contacts/Add'
import ContactEdit from '@/views/contacts/Edit'

import Login from '@/views/Login'


Vue.use(Router)

export default new Router({
  mode: 'hash',
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      name: 'Contacts',
      component: Contacts,
    },
    {
      path: '/contacts/add',
      name: 'ContactAdd',
      component: ContactAdd,
    },
    {
      path: '/contacts/edit/:contactId',
      name: 'ContactEdit',
      component: ContactEdit,
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
    
  ]
})
