<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNewGoalRequest;
use App\Http\Requests\CreateNewSubgoalRequest;
use App\Http\Requests\EditGoalTitleRequest;
use App\Http\Requests\TagGoalRequest;
use App\Http\Requests\RemoveTagRequest;
use Illuminate\Support\Facades\Auth;
use TomLingham\Searchy\Facades\Searchy;

class GoalController extends Controller {

  public function index() {

    $all_goals = Goal::allGoals()->get();

    return view('goals.index')->with('goals', $all_goals);
  }

  public function apiIndex() {

    $all_goals = Goal::allGoals()->get();

    return [
      'data' => [
        'all_goals' => $all_goals,
      ],
    ];

  }


  public function apiPopular() {

    $popular_goals = Goal::allGoals()->paginate(8);

    return [
      'data' => [
        'popular_goals' => $popular_goals,
      ],
    ];

  }


  public function apiNew(CreateNewSubgoalRequest $request) {
    //When a user creates a new subgoal from an existing goal

    $goal = Goal::find($request->goal_id);

    $goal->createNewSubgoal($request->cost, $request->hours, $request->days);

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }


  /*
  public function create(CreateNewGoalRequest $request) {
    //When a user creates an entirely new goal

    Goal::newGoal($request->title, $request->cost, $request->days, $request->hours);

    return redirect()->route('subgoals');
  }
  */


  public function apiCreate(CreateNewGoalRequest $request) {
    //When a user creates an entirely new goal

    Goal::newGoal($request->title, $request->cost, $request->days, $request->hours);

    return [
      'data' => [
        'success' => true,
      ],
    ];
  }


  public function view($slug) {

    $goal = Goal::where('slug', $slug)->first();

    $user = Auth::user();
    $loggedIn = false;
    $userHasGoals = false;
    $hasProfileInfo = false;
    $userHasThisGoalOnList = false;

    if ($user) {

      $loggedIn = true;

      if (count($user->subgoals)) {
          $userHasGoals = true;

          $profile = $user->profile;

          if ($profile->cost_per_year && $profile->days_per_year && $profile->hours_per_year && $profile->birthday) {
            $hasProfileInfo = true;

            if($user->subgoals->where('slug', $slug)->first()) {
              $userHasThisGoalOnList = true;
            }
          }

      }

    }

    return view('goals.view')->with([
      'goal' => $goal,
      'loggedIn' => $loggedIn,
      'userHasGoals' => $userHasGoals,
      'hasProfileInfo' => $hasProfileInfo,
      'userHasThisGoalOnList' => $userHasThisGoalOnList,
      'user' => $user,
    ]);

  }

  /*
  public function apiView(Goal $goal) {
    $goal->subgoals;
    return $goal;
  }
  */

  public function apiSearch(Request $request) {
    //Need some validation that this is actually a string and safe to search with

    $term = $request->search;
    $results = Searchy::search('goals')->fields('name')->query($term)->get();

    return $results;
  }


  public function apiTag(TagGoalRequest $request, Goal $goal) {

    $name = $request->tag_name;

    $tagId = $goal->attachTagToGoal($name);

    return [
      'data' => [
        'success' => true,
        'tag_id' => $tagId,
      ],
    ];

  }


  public function apiRemoveTag(RemoveTagRequest $request, Goal $goal) {

    $tagId = $request->tag_id;
    $goal->removeTagFromGoal($tagId);

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }


  public function apiDelete(Goal $goal) {

    $goal->deleteGoal();

    return [
      'data' => [
        'success' => true,
      ],
    ];
  }


  public function apiEditTitle(EditGoalTitleRequest $request, Goal $goal) {

    $goal->editGoal($request->newTitle);

    return [
      'data' => [
        'success' => true,
      ],
    ];
  }


}
