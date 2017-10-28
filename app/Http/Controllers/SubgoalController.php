<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subgoal;
use App\Goal;
use Illuminate\Support\Facades\Auth;

class SubgoalController extends Controller

{
    public function index() {

        $user = Auth::user();
        $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();

        return view('subgoals.index')->with([
            'subgoals' => $subgoals,
        ]);
    }

    public function apiIndex() {

        $user = Auth::user();
        $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();

        return [
          'data' => [
            'subgoals' => $subgoals,
          ]
        ];

    }

    public function apiSorted($order) {

        $user = Auth::user();

        if ($order == 'cost') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'desc')->get();
        }

        else if ($order == 'hours') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'desc')->get();
        }
        else if ($order == 'days') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'desc')->get();
        }

        else {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();
        }


        return [
          'data' => [
            'subgoals' => $subgoals,
          ]
        ];

    }

    public function view(Subgoal $subgoal) {

        $goal = $subgoal->goal;

        return view('subgoals.view')->with([
            'subgoal' => $subgoal,
            'goal' => $goal,
        ]);

    }

    public function update(Request $request, Subgoal $subgoal) {

        // Need to authenticate both that this is the users goal and make sure that the request is valid

        $subgoal->cost = $request->cost;
        $subgoal->hours = $request->hours;
        $subgoal->days = $request->days;
        $subgoal->save();

        $subgoal->goal->updateGoalAverages();

        return redirect()->back();
    }

    public function delete(Subgoal $subgoal)  {
        $goal_id = $subgoal->goal->id;

        $subgoal->forceDelete();

        Goal::find($goal_id)->updateGoalAverages();

        return redirect()->route('subgoals');
    }

}
