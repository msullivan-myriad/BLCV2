<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TomLingham\Searchy\Facades\Searchy;

class GoalController extends Controller
{
    public function index() {

        $all_goals = Goal::orderBy('subgoals_count', 'desc')->get();

        return view('goals.index')->with( 'goals', $all_goals);
    }

    public function add(Goal $goal) {
        //When a user adds an existing goal as a subgoal

        //Needs more validation
        $user = Auth::user();
        $user->addDefaultGoal($goal);
        return redirect()->route('subgoals');
    }

    public function new(Request $request, Goal $goal) {
        //When a user creates a new subgoal from an existing goal
        $user = Auth::user();
        $cost = $request->cost;
        $hours = $request->hours;
        $days = $request->days;
        //Need some validation above here

        $user->addUniqueGoal($goal, $cost, $hours, $days);
        return redirect()->route('subgoals');
    }

    public function create(Request $request) {
        //When a user creates a new goal

        //Need some validation here
        $user = Auth::user();
        $user->newGoal($request->title, $request->cost, $request->days, $request->hours);
        return redirect()->route('subgoals');
    }

    public function view(Goal $goal) {

        $subgoals = $goal->subgoals;

        return view('goals.view')->with([
            'goal' => $goal,
            'subgoals' => $subgoals,
       ] );
    }

    public function search(Request $request) {
        //Need some validation that this is actually a string and safe to search with
        $term = $request->search;
        $results = Searchy::search('goals')->fields('name')->query($term)->get();

        return view('goals.search')->with('results', $results);
    }

}
