
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Import React Components
 */

import ReactDOM from 'react-dom'
import React from 'react'
import AdminTagsPage from './components/AdminTagsPage'
import AdminIndividualTagPage from './components/AdminIndividualTagPage'
import MainCalculatorSection from './components/calculator/MainCalculatorSection'
import YourGoalData from './components/YourGoalData'
import IndividualGoalGeneralStats from './components/IndividualGoalGeneralStats'
import TagsSortingSection from './components/TagsSortingSection'
import MainFindGoals from './components/find-goals/MainFindGoals'
import MainViewGoalPage from './components/view-goal/MainViewGoalPage'

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
    ReactDOM.render(<MainCalculatorSection/>, document.getElementById('calculate-section'));
}

if (document.getElementById('your-goal-data')) {
    ReactDOM.render(<YourGoalData/>, document.getElementById('your-goal-data'));
}

if (document.getElementById('individual-goal-general-stats')) {
    ReactDOM.render(<IndividualGoalGeneralStats/>, document.getElementById('individual-goal-general-stats'));
}

if (document.getElementById('tags-sorting-section')) {
    ReactDOM.render(<TagsSortingSection/>, document.getElementById('tags-sorting-section'));
}

if (document.getElementById('main-find-goals')) {
    ReactDOM.render(<MainFindGoals/>, document.getElementById('main-find-goals'));
}

if (document.getElementById('view-goal-page')) {
    ReactDOM.render(<MainViewGoalPage/>, document.getElementById('view-goal-page'));
}


