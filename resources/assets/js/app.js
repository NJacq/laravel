
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

// importer les pages
import Home from './components/HomeComponent'
import Departements from './components/DepartementsComponent'
import Departement from './components/DepartementComponent'
import Regions from './components/RegionsComponent'
import Region from './components/RegionComponent'
import ChartDep from './components/ChartDepComponent'
import Vue2Filters from 'vue2-filters'

Vue.use(Vue2Filters)
Vue.use(VueRouter)

Vue.component('regions', require('./components/RegionsComponent.vue'));
Vue.component('region', require('./components/RegionComponent.vue'));
Vue.component('departements', require('./components/DepartementsComponent.vue'));
Vue.component('departement', require('./components/DepartementComponent.vue'));
Vue.component('home', require('./components/HomeComponent.vue'));
Vue.component('chartdep', require('./components/ChartDepComponent.vue'));


const routes = [
    { path: '/', component: Home },
    { path: '/regions', component: Regions },
    { path: '/region/:id', component: Region },
    { path: '/departements', component: Departements },
    { path: '/departement/:id', component: Departement },
    { path: '/departement/:id/chart', component: ChartDep }
    
  ]

  const router = new VueRouter({
    // mode: 'history',
    // base: '',
    routes, // short for `routes: routes`

})

new Vue({
    el: '#app',
    router: router,
})
