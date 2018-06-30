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
  Route::get('tags', 'TagsController@apiPopularTags');
  Route::get('tags/search', 'TagsController@apiTagsSearch');
  Route::get('tags/{tag}', 'TagsController@apiGoalsWithTag');
  Route::get('category-goals/{category}/', 'TagsController@categoryGoalsFiltering');
  Route::get('experiences/{goal}', 'ExperienceController@viewGoalsExperiences');

  /*
   *  API routes that require auth
   */

  Route::group(['middleware' => ['auth']], function () {

    Route::get('subgoals', 'SubgoalController@apiIndex');
    Route::get('subgoals/sort/{order}', 'SubgoalController@apiSorted');
    Route::get('subgoals/single/{subgoal}', 'SubgoalController@apiView');
    Route::post('subgoals/{subgoal}/', 'SubgoalController@apiUpdate');
    Route::delete('subgoals/{subgoal}/', 'SubgoalController@apiDelete');

    Route::post('experience/{experience}/edit', 'ExperienceController@editExperience');
    Route::post('experience/{experience}/upvote', 'ExperienceController@upVoteExperience');
    Route::post('experience/{experience}/remove-upvote', 'ExperienceController@removeUpVoteFromExperience');
    Route::post('experience/{experience}/downvote', 'ExperienceController@downVoteExperience');
    Route::post('experience/{experience}/remove-downvote', 'ExperienceController@removeDownVoteFromExperience');

    Route::post('experiences/{goal}', 'ExperienceController@addNewExperienceToGoal');

    Route::post('/goals/', 'GoalController@apiNew');
    Route::post('/goals/create', 'GoalController@apiCreate');

  });


  /*
   *  API routes dedicated to working with profile
   */

  Route::prefix('profile')->group(function () {

    Route::group(['middleware' => ['auth']], function () {

        Route::get('profile-information', 'ProfileController@profileInformation');
        Route::post('dedicated-per-year', 'ProfileController@setDedicatedPerYear');
        Route::post('set-birthdate', 'ProfileController@setBirthdate');

    });

  });

  /*
   *  API routes dedicated to working with stats
   */

  Route::prefix('stats')->group(function () {

    Route::group(['middleware' => ['auth']], function () {

      Route::get('totals', 'StatsController@totals');
      Route::get('completion-age', 'StatsController@completionAge');
      Route::get('most-and-least-difficult', 'StatsController@mostAndLeastDifficult');
      Route::get('target-completion-age/{age}', 'StatsController@targetCompletionAge');
      Route::get('individual-goal-stats/{slug}', 'StatsController@individualGoalStats');
      Route::get('users-tags', 'StatsController@getAllUsersTags');
      Route::get('users-tags/{tag}', 'StatsController@getUsersIndividualTag');

    });

  });


  /*
   *  API Admin Middleware
   */

  Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['admin']], function () {

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
 *  Base Routes that require auth
 */

Route::group(['middleware' => ['auth']], function () {

  Route::get('calculator', 'SubgoalController@index')->name('calculator');

});


/*
 *  Routes that require admin user
 */

Route::prefix('blc-admin')->group(function () {

  Route::group(['middleware' => ['admin']], function () {

    Route::get('/', 'AdminController@index')->name('admin-panel');
    Route::get('tags', 'AdminController@tags')->name('admin-tags');
    Route::get('tags/individual', 'AdminController@individualTag')->name('individual-tag');

  });

});



