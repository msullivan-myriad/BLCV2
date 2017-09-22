
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
import AdminIndividualTagPage from './components/AdminIndividualTagPage';

/**
 *  Specify where React should render
 */

if (document.getElementById('adminpage-tag-goals')) {
    ReactDOM.render(<AdminTagsPage/>, document.getElementById('adminpage-tag-goals'));
}


if (document.getElementById('adminpage-individual-tag')) {
    ReactDOM.render(<AdminIndividualTagPage/>, document.getElementById('adminpage-individual-tag'));
}









import { Button, notification } from 'antd';
import 'antd/dist/antd.css';


const openNotification = () => {
    notification.open({
        message: 'Notification Title',
        description: 'This is the content of the notification. This is the content of the notification. This is the content of the notification.',
        placement: 'bottomRight'
    });
};

ReactDOM.render(
    <Button type="primary" onClick={openNotification}>Open the notification box</Button>
    , document.getElementById('ant-test'));

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
