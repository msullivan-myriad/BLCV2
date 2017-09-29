
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
import CalculateSection from './components/CalculateSection';
import UserSubgoalsSection from './components/UserSubgoalsSection';

/**
 *  Specify where React should render
 */

if (document.getElementById('adminpage-tag-goals')) {
    ReactDOM.render(<AdminTagsPage/>, document.getElementById('adminpage-tag-goals'));
}

if (document.getElementById('adminpage-individual-tag')) {
    ReactDOM.render(<AdminIndividualTagPage/>, document.getElementById('adminpage-individual-tag'));
}

if (document.getElementById('calculate-section')) {
    ReactDOM.render(<CalculateSection/>, document.getElementById('calculate-section'));
}

if (document.getElementById('user-subgoals-section')) {
    ReactDOM.render(<UserSubgoalsSection/>, document.getElementById('user-subgoals-section'));
}
