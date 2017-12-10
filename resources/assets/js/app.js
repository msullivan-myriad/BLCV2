
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
import GoalsSearch from './components/GoalsSearch';
import GoalsFeatured from './components/GoalsFeatured';
import YourGoalData from './components/YourGoalData';
import IndividualGoalGeneralStats from './components/IndividualGoalGeneralStats';

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

if (document.getElementById('goals-search')) {
    ReactDOM.render(<GoalsSearch/>, document.getElementById('goals-search'));
}

if (document.getElementById('goals-featured')) {
    ReactDOM.render(<GoalsFeatured/>, document.getElementById('goals-featured'));
}

if (document.getElementById('your-goal-data')) {
    ReactDOM.render(<YourGoalData/>, document.getElementById('your-goal-data'));
}

if (document.getElementById('individual-goal-general-stats')) {
    ReactDOM.render(<IndividualGoalGeneralStats/>, document.getElementById('individual-goal-general-stats'));
}

