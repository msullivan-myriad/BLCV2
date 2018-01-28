<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNewGoalRequest;
use App\Http\Requests\CreateNewSubgoalRequest;
use App\Http\Requests\TagGoalRequest;
use App\Http\Requests\RemoveTagRequest;
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

    $popular_goals = Goal::allGoals()->paginate(10);

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

  public function create(CreateNewGoalRequest $request) {
    //When a user creates an entirely new goal

    Goal::newGoal($request->title, $request->cost, $request->days, $request->hours);

    return redirect()->route('subgoals');
  }

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

    return view('goals.view')->with([
      'goal' => $goal,
    ]);

  }

  public function apiView(Goal $goal) {
    $goal->subgoals;
    return $goal;
  }

  public function apiSearch(Request $request) {
    //Need some validation that this is actually a string and safe to search with

    $term = $request->search;
    $results = Searchy::search('goals')->fields('name')->query($term)->get();

    return $results;
  }

  /*
  public function tag(Request $request, Goal $goal) {
    //Need to validate this name better, maybe something in the model?
    $name = $request->tag_name;

    $goal->attachTagToGoal($name);

    return redirect()->back();
  }
  */

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


  /*
  public function removeTag(Request $request, Goal $goal) {
    //Detach the requested tag from goal
    // Need to add validation on this request

    $tagId = $request->tag_name;
    $goal->removeTagFromGoal($tagId);

    return redirect()->back();
  }
  */

  public function apiRemoveTag(RemoveTagRequest $request, Goal $goal) {

    $tagId = $request->tag_id;
    $goal->removeTagFromGoal($tagId);

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }

  /*
  public function delete(Goal $goal) {
    //Delete this goal and all of its subgoals
    $goal->deleteGoal();
    return redirect()->route('admin-panel');
  }
  */

  public function apiDelete(Goal $goal) {

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
    $goals = Goal::goalsWithSpecificTag($tag->id)->paginate(3);

    return $goals;
  }


}
