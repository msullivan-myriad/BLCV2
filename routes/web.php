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

//Basic Application Routes
Route::get('/home', 'HomeController@index');
Route::get('search', 'GoalController@search')->name('search-goals');
Route::get('goals', 'GoalController@index')->name('goals');
Route::get('goal/{goal}', 'GoalController@view')->name('view-goal');


Route::prefix('api')->group(function() {

    //Basic API Routes
    Route::get('/goals/', 'GoalController@apiIndex');
    Route::get('/popular', 'GoalController@apiPopular');
    Route::get('/search/', 'GoalController@apiSearch');

    //Basic API Routes (These should require auth)
    Route::get('subgoals', 'SubgoalController@apiIndex');

    Route::get('subgoals/{order}', 'SubgoalController@apiSorted');

    Route::get('subgoal/{subgoal}', 'SubgoalController@apiView');
    Route::post('subgoals/{subgoal}/', 'SubgoalController@apiUpdate');
    Route::delete('subgoals/{subgoal}/', 'SubgoalController@apiDelete');

    Route::post('/goals/', 'GoalController@apiNew');
    Route::post('/goals/create', 'GoalController@apiCreate');

    Route::get('tags', 'GoalController@apiPopularTags');
    Route::get('tags/{tag}', 'GoalController@apiGoalsWithTag');


    //Profile API Routes
    Route::prefix('profile')->group(function() {

      Route::get('dedicated-per-year', 'ProfileController@dedicatedPerYear');
      Route::post('dedicated-per-year', 'ProfileController@setDedicatedPerYear');

    });


    //API Stats Middleware
    //Stats Middleware should have some auth
    Route::prefix('stats')->group(function() {
        //This route group should require authentication
        Route::get('totals', 'StatsController@totals');
        Route::get('difficulty', 'StatsController@difficulty');
        Route::get('most-and-least-difficult', 'StatsController@mostAndLeastDifficult');
        Route::get('completion-age', 'StatsController@completionAge');
        Route::get('target-completion-age/{age}', 'StatsController@targetCompletionAge');
        Route::get('individual-goal-stats/{slug}', 'StatsController@individualGoalStats');
    });


    //API Admin Middleware
    //Admin Middleware should have some auth
    Route::group(['middleware' => ['admin']], function() {

      Route::prefix('admin')->group(function() {

        Route::get('api-tags', 'AdminController@apiTags');
        Route::get('api-tags/{tag}', 'AdminController@apiIndividualTag');
        Route::delete('/goals/{goal}/tag', 'GoalController@apiRemoveTag');
        Route::post('goals/{goal}/tag', 'GoalController@apiTag');
        Route::delete('goals/{goal}', 'GoalController@apiDelete');
        Route::post('goals/{goal}/edit', 'GoalController@apiEditTitle');

      });

    });

});


Route::group(['middleware' => ['auth']], function() {

    Route::get('subgoals', 'SubgoalController@index')->name('subgoals');
    Route::get('subgoals/{subgoal}', 'SubgoalController@view')->name('view-subgoal');
    Route::post('subgoals/{subgoal}/', 'SubgoalController@update')->name('update-subgoal');
    Route::delete('subgoals/{subgoal}/', 'SubgoalController@delete')->name('delete-subgoal');


    Route::post('goals/', 'GoalController@create')->name('create-goal');
    Route::post('goals/{goal}', 'GoalController@new')->name('new-goal');

    Route::get('stats', 'StatsController@index')->name('stats');

});


Route::group(['middleware' => ['admin']], function() {

    Route::prefix('blc-admin')->group(function() {

        Route::get('/', 'AdminController@index')->name('admin-panel');
        Route::get('tags', 'AdminController@tags')->name('admin-tags');
        Route::get('tags/individual', 'AdminController@individualTag')->name('individual-tag');
        Route::get('/goals/{goal}', 'AdminController@goal')->name('admin-goal');

    });


    Route::post('goals/{goal}/tag', 'GoalController@tag')->name('tag-goal');
    Route::delete('goals/{goal}/tag', 'GoalController@removeTag')->name('remove-tag');

    Route::delete('goals/{goal}', 'GoalController@delete')->name('delete-goal');
    Route::post('goals/{goal}/edit', 'GoalController@edit')->name('edit-goal');

});



