<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('profile', 'ProfileController@view')->name('profile');
Route::post('profile', 'ProfileController@edit')->name('profile');


Route::get('goals', 'GoalController@index')->name('goals');
Route::post('goals/', 'GoalController@create')->name('create-goal');
Route::get('goals/{goal}', 'GoalController@view')->name('view-goal');
Route::post('goals/{goal}', 'GoalController@new')->name('new-goal');
Route::get('search', 'GoalController@search')->name('search-goals');



Route::get('subgoals', 'SubgoalController@index')->name('subgoals');
Route::get('subgoals/{subgoal}', 'SubgoalController@view')->name('view-subgoal');
Route::post('subgoals/{subgoal}/', 'SubgoalController@update')->name('update-subgoal');
Route::delete('subgoals/{subgoal}/', 'SubgoalController@delete')->name('delete-subgoal');
