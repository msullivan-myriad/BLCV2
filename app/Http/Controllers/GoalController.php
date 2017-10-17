<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNewGoalRequest;
use App\Http\Requests\CreateNewSubgoalRequest;
use Illuminate\Support\Facades\Auth;
use TomLingham\Searchy\Facades\Searchy;

class GoalController extends Controller
{
    public function index() {

        $all_goals = Goal::orderBy('subgoals_count', 'desc')->get();

        return view('goals.index')->with( 'goals', $all_goals);
    }

    public function apiIndex() {

        $all_goals = Goal::orderBy('subgoals_count', 'desc')->get();

        return [
            'data' => [
                'all_goals' => $all_goals
            ]
        ];

    }

    public function apiPopular($number) {

        //Need to figure out some kind of validation for number here
        $popular_goals = Goal::orderBy('subgoals_count', 'desc')->take($number)->get();

        return [
            'data' => [
                'popular_goals' => $popular_goals
            ]
        ];

    }

    public function new(CreateNewSubgoalRequest $request, Goal $goal) {
        //When a user creates a new subgoal from an existing goal
        $user = Auth::user();

        $cost = $request->cost;
        $hours = $request->hours;
        $days = $request->days;

        $user->addUniqueGoal($goal, $cost, $hours, $days);
        return redirect()->route('subgoals');
    }

    public function apiNew(CreateNewSubgoalRequest $request) {
        //When a user creates a new subgoal from an existing goal

        $user = Auth::user();

        $cost = $request->cost;
        $hours = $request->hours;
        $days = $request->days;
        $goal = Goal::find($request->goal_id);

        $user->addUniqueGoal($goal, $cost, $hours, $days);

        return [
            'data' => [
                'success' => true,
            ]
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
            ]
        ];
    }

    public function view(Goal $goal) {

        $subgoals = $goal->subgoals;

        return view('goals.view')->with([
            'goal' => $goal,
            'subgoals' => $subgoals,
       ] );
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
        // Need to add tags to the database seeder... Maybe it's not nessesary
        // Request for tags?

        //Search via name here rather than id in the case the tag already exists
        $tag = Tag::where('name', $request->tag_name)->first();

        //Create a new tag if the tag doesn't yet exist
        if (!$tag) {
            $tag = new Tag;
            $tag->name = $request->tag_name;
            $tag->save();
        }

        $goal->tags()->attach($tag);

        return redirect()->back();
    }

    public function apiTag(Request $request, Goal $goal) {
        // Need to add tags to the database seeder... Maybe it's not nessesary
        // Request for tags?
        //Request validation for tags?

        //Search via name here rather than id in the case the tag already exists
        $tag = Tag::where('name', $request->tag_name)->first();

        //Create a new tag if the tag doesn't yet exist
        if (!$tag) {
            $tag = new Tag;
            $tag->name = $request->tag_name;
            $tag->save();
        }

        $goal->tags()->attach($tag);

        //Need to validate better
        return [
              'data' => [
                  'success' => true,
                  'tag_id' => $tag->id
              ]
          ];

    }


    public function removeTag(Request $request, Goal $goal) {
        //Detach the requested tag from goal
        // Need to add validation on this request

        $tagId = $request->tag_name;
        $tag = Tag::where('id', $tagId)->first();

        $goal->tags()->detach($tag);

        return redirect()->back();

    }

    public function apiRemoveTag(Request $request, Goal $goal) {
        //Detach the requested tag from goal
        // Need to add validation on this request

        $tagId = $request->tag_id;

        $tag = Tag::where('id', $tagId)->first();

        $goal->tags()->detach($tag);

        //Need to validate better
        return [
              'data' => [
                  'success' => true
              ]
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
            'success' => true
          ]
        ];
    }

    public function edit(Request $request, Goal $goal) {
        $goal->editGoal('Test');
        return redirect()->back();
    }

    public function apiEditTitle(Request $request, Goal $goal) {

        $goal->editGoal($request->newTitle);
        return [
          'data' => [
            'success' => true
          ]
        ];
    }


}
