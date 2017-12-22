<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNewGoalRequest;
use App\Http\Requests\CreateNewSubgoalRequest;
use Illuminate\Support\Facades\Auth;
use TomLingham\Searchy\Facades\Searchy;

class GoalController extends Controller {

  public function index() {

    $all_goals = Goal::getAllGoals();

    return view('goals.index')->with('goals', $all_goals);
  }

  public function apiIndex() {

    $all_goals = Goal::getAllGoals();

    return [
      'data' => [
        'all_goals' => $all_goals,
      ],
    ];

  }

  public function apiPopular() {

    $popular_goals = Goal::getPaginatedPopularGoals();

    return [
      'data' => [
        'popular_goals' => $popular_goals,
      ],
    ];

  }

  /*
  public function new(CreateNewSubgoalRequest $request, Goal $goal) {
    //When a user creates a new subgoal from an existing goal
    $user = Auth::user();

    $user->addUniqueGoal($goal, $request->cost, $request->hours, $request->days);
    return redirect()->route('subgoals');
  }
  */

  public function apiNew(CreateNewSubgoalRequest $request) {
    //When a user creates a new subgoal from an existing goal

    $user = Auth::user();
    $goal = Goal::find($request->goal_id);

    $user->addUniqueGoal($goal, $request->cost, $request->hours, $request->days);

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }

  public function create(CreateNewGoalRequest $request) {
    //When a user creates an entirely new goal

    //Need some validation here
    $user = Auth::user();
    $user->newGoal($request->title, $request->cost, $request->days, $request->hours);
    return redirect()->route('subgoals');
  }

  public function apiCreate(CreateNewGoalRequest $request) {
    //When a user creates an entirely new goal

    $user = Auth::user();
    $user->newGoal($request->title, $request->cost, $request->days, $request->hours);
    return [
      'data' => [
        'success' => true,
      ],
    ];
  }

  public function view($slug) {
    //Some kind of validation

    $goal = Goal::where('slug', $slug)->first();

    return view('goals.view')->with([
      'goal' => $goal,
    ]);

  }

  public function apiView(Goal $goal) {
    $goal->subgoals;
    return $goal;
  }

  public function search(Request $request) {
    //Need some validation that this is actually a string and safe to search with
    $term = $request->search;
    $results = Searchy::search('goals')->fields('name')->query($term)->get();

    return view('goals.search')->with('results', $results);
  }

  public function apiSearch(Request $request) {
    //Need some validation that this is actually a string and safe to search with

    $term = $request->search;
    $results = Searchy::search('goals')->fields('name')->query($term)->get();

    return $results;
  }

  public function tag(Request $request, Goal $goal) {
    //Need to add tags to the database seeder... Maybe it's not nessesary
    //Need to validate this name better, maybe something in the model?
    $name = $request->tag_name;

    $goal->attachTagToGoal($name);

    return redirect()->back();
  }

  public function apiTag(Request $request, Goal $goal) {
    //Need to add tags to the database seeder... Maybe it's not nessesary
    //Need to validate this name better, maybe something in the model?
    $name = $request->tag_name;

    $tagId = $goal->attachTagToGoal($name);

    return [
      'data' => [
        'success' => true,
        'tag_id' => $tagId,
      ],
    ];

  }


  public function removeTag(Request $request, Goal $goal) {
    //Detach the requested tag from goal
    // Need to add validation on this request

    $tagId = $request->tag_name;
    $goal->removeTagFromGoal($tagId);

    return redirect()->back();

  }

  public function apiRemoveTag(Request $request, Goal $goal) {
    //Detach the requested tag from goal
    //Need to add validation on this request

    $tagId = $request->tag_id;
    $goal->removeTagFromGoal($tagId);

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }

  public function delete(Goal $goal) {
    //Delete this goal and all of its subgoals
    $goal->deleteGoal();
    return redirect()->route('admin-panel');
  }

  public function apiDelete(Goal $goal) {
    //Delete this goal and all of its subgoals
    $goal->deleteGoal();
    return [
      'data' => [
        'success' => true,
      ],
    ];
  }

  /*
  public function edit(Request $request, Goal $goal) {
    $goal->editGoal('Test');
    return redirect()->back();
  }
  */

  public function apiEditTitle(Request $request, Goal $goal) {

    $goal->editGoal($request->newTitle);

    return [
      'data' => [
        'success' => true,
      ],
    ];
  }

  public function apiPopularTags() {
    //Return most popular tags
    $tags = Tag::mostPopularTags();

    return [

      'data' => [
        'tags' => $tags,
      ],

    ];

  }

  public function apiGoalsWithTag(Tag $tag) {
    //Return goals that have this tag
    //Need some validation here on the tag
    $goals = Goal::getPaginatedGoalsWithTag($tag->id);

    return $goals;
  }


}
