
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
import AdminTagsPage from './components/AdminTagsPage';
//import AdminGoal from './components/AdminGoal';

/**
 *  Specify where React should render
 */

if (document.getElementById('tag-goals')) {
    ReactDOM.render(<AdminTagsPage/>, document.getElementById('tag-goals'));
}


/*
window.Vue = require('vue');

Vue.component('goals-page', require('./components/GoalsPage.vue'));
Vue.component('goal', require('./components/Goal.vue'));
Vue.component('stats-goal', require('./components/StatsGoal.vue'));
Vue.component('basic-stats', require('./components/BasicStats.vue'));
Vue.component('top-fives', require('./components/TopFives.vue'));
Vue.component('search-goals', require('./components/SearchGoals.vue'));

const app = new Vue({
    el: '#app'
});

*/
