
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vue2Filters from 'vue2-filters'
import vSelect from 'vue-select'

// importer les pages
import Home from './components/HomeComponent'
import Regions from './components/RegionsComponent'
import Region from './components/RegionComponent'
import Departement from './components/DepartementComponent'
import Commune from './components/CommuneComponent'
import Epci from './components/EpciComponent'
import Arrondissement from './components/ArrondissementComponent'



Vue.use(Vue2Filters)
Vue.use(VueRouter)

Vue.component('v-select', vSelect)


Vue.component('regions', require('./components/RegionsComponent.vue'));
Vue.component('region', require('./components/RegionComponent.vue'));
Vue.component('departement', require('./components/DepartementComponent.vue'));
Vue.component('epci', require('./components/EpciComponent.vue'));
Vue.component('commune', require('./components/CommuneComponent.vue'));
Vue.component('arrondissement', require('./components/ArrondissementComponent.vue'));
Vue.component('home', require('./components/HomeComponent.vue'));



const routes = [
    { path: '/', component: Home },
    { path: '/regions', component: Regions },
    { path: '/region/:id', component: Region }, 
    { path: '/departement/:id', component: Departement },
    { path: '/commune/:id', component: Commune },
    { path: '/epci/:id', component: Epci },
    { path: '/arrondissement/:id', component: Arrondissement },

    
  ]

  const router = new VueRouter({
    // mode: 'history',
    // base: '',
    routes, // short for `routes: routes`

})

new Vue({
    el: '#app',
    router: router,    
});
    
    