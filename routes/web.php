<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
  return view('welcome');
});



//I think I would prefer if the prefix is always on the outside of the route group
//The middleware would always then be on the inside
//Once I have enough tests to feel more comfortable with refactoring I will make the switch


Auth::routes();

/*
 *  Basic application routes
 */

Route::get('/home', 'HomeController@index');
Route::get('goals', 'GoalController@index')->name('goals');
Route::get('goal/{goal}', 'GoalController@view')->name('view-goal');
Route::get('category/{tag}', 'TagsController@view')->name('view-tags');


/*
 *  Basic API routes
 */

Route::prefix('api')->group(function () {

  /*
   *  API routes that don't require auth
   */

  Route::get('/goals/', 'GoalController@apiIndex');
  Route::get('/popular', 'GoalController@apiPopular');
  Route::get('/search/', 'GoalController@apiSearch');
  Route::get('tags', 'GoalController@apiPopularTags');
  Route::get('tags/{tag}', 'GoalController@apiGoalsWithTag');
  Route::get('category-goals/{category}', 'TagsController@categoryGoalsFiltering');


  /*
   *  API routes that should require auth,
   *  NEED TO ADD AUTH MIDDLEWARE HERE
   *  DO THIS WHILE CREATING ROUTE TESTS
   */

  Route::get('subgoals', 'SubgoalController@apiIndex');
  Route::get('subgoals/{order}', 'SubgoalController@apiSorted');
  Route::get('subgoal/{subgoal}', 'SubgoalController@apiView');
  Route::post('subgoals/{subgoal}/', 'SubgoalController@apiUpdate');
  Route::delete('subgoals/{subgoal}/', 'SubgoalController@apiDelete');
  Route::post('/goals/', 'GoalController@apiNew');
  Route::post('/goals/create', 'GoalController@apiCreate');


  /*
   *  API routes dedicated to working with profile
   */

  Route::prefix('profile')->group(function () {

    Route::get('profile-information', 'ProfileController@profileInformation');
    Route::post('dedicated-per-year', 'ProfileController@setDedicatedPerYear');
    Route::post('set-birthdate', 'ProfileController@setBirthdate');

  });



  /*
   *  API routes dedicated to working with stats
   *  SOME OF THESE ROUTES WILL REQUIRE AUTH
   */

  Route::prefix('stats')->group(function () {

    //This route group should require authentication
    Route::get('totals', 'StatsController@totals');
    Route::get('difficulty', 'StatsController@difficulty');
    Route::get('most-and-least-difficult', 'StatsController@mostAndLeastDifficult');
    Route::get('completion-age', 'StatsController@completionAge');
    Route::get('target-completion-age/{age}', 'StatsController@targetCompletionAge');
    Route::get('individual-goal-stats/{slug}', 'StatsController@individualGoalStats');
    Route::get('users-tags', 'StatsController@getAllUsersTags');
    Route::get('users-tags/{tag}', 'StatsController@getUsersIndividualTag');

    //These stats routes do not need authentication
    Route::get('individual-goal-general-stats/{slug}', 'StatsController@individualGoalGeneralStats');

  });


  /*
   *  API Admin Middleware
   */

  Route::group(['middleware' => ['admin']], function () {

    Route::prefix('admin')->group(function () {

      Route::get('api-tags', 'AdminController@apiTags');
      Route::get('api-tags/{tag}', 'AdminController@apiIndividualTag');
      Route::delete('/goals/{goal}/tag', 'GoalController@apiRemoveTag');
      Route::post('goals/{goal}/tag', 'GoalController@apiTag');
      Route::delete('goals/{goal}', 'GoalController@apiDelete');
      Route::post('goals/{goal}/edit', 'GoalController@apiEditTitle');

    });

  });

});

/*
 *  Routes that require authentication
 */

Route::group(['middleware' => ['auth']], function () {

  Route::get('subgoals', 'SubgoalController@index')->name('subgoals');
  Route::get('subgoals/{subgoal}', 'SubgoalController@view')->name('view-subgoal');
  Route::post('subgoals/{subgoal}/', 'SubgoalController@update')->name('update-subgoal');
  Route::delete('subgoals/{subgoal}/', 'SubgoalController@delete')->name('delete-subgoal');
  Route::post('goals/', 'GoalController@create')->name('create-goal');
  Route::get('stats', 'StatsController@index')->name('stats');

});


/*
 *  Routes that require admin user
 */

Route::group(['middleware' => ['admin']], function () {

  Route::prefix('blc-admin')->group(function () {

    Route::get('/', 'AdminController@index')->name('admin-panel');
    Route::get('tags', 'AdminController@tags')->name('admin-tags');
    Route::get('tags/individual', 'AdminController@individualTag')->name('individual-tag');
    Route::get('/goals/{goal}', 'AdminController@goal')->name('admin-goal');

  });

  //Route::post('goals/{goal}/tag', 'GoalController@tag')->name('tag-goal');
  //Route::delete('goals/{goal}/tag', 'GoalController@removeTag')->name('remove-tag');
  //Route::delete('goals/{goal}', 'GoalController@delete')->name('delete-goal');
  Route::post('goals/{goal}/edit', 'GoalController@edit')->name('edit-goal');

});



