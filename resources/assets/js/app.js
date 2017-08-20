
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Import React Components
 */

import ReactDOM from 'react-dom';
import React from 'react';
import AdminGoal from './components/AdminGoal';

/**
 *  Specify where React should render
 */

if (document.getElementById('tag-goals')) {
    ReactDOM.render(<AdminGoal/>, document.getElementById('tag-goals'));
}


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('goals-page', require('./components/GoalsPage.vue'));
Vue.component('goal', require('./components/Goal.vue'));
Vue.component('stats-goal', require('./components/StatsGoal.vue'));
Vue.component('basic-stats', require('./components/BasicStats.vue'));
Vue.component('top-fives', require('./components/TopFives.vue'));
Vue.component('search-goals', require('./components/SearchGoals.vue'));

const app = new Vue({
    el: '#app'
});

/**
 * Some basic api testing
 */

/**
 * Initializing React components on pages
 */

