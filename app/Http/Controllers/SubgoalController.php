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

        if ($order == 'cost-desc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'desc')->get();
        }

        else if ($order == 'cost-asc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'asc')->get();
        }

        else if ($order == 'hours-desc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'desc')->get();
        }

        else if ($order == 'hours-asc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'asc')->get();
        }

        else if ($order == 'days-desc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'desc')->get();
        }

        else if ($order == 'days-asc') {
          $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'asc')->get();
        }

        else if ($order == 'popular-desc') {
          $subgoals = Subgoal::with('goal')
            ->join('goals', 'subgoals.goal_id', '=', 'goals.id')
            ->where('user_id', $user->id)
            ->orderBy('goals.subgoals_count', 'DESC')
            ->get();
        }

        else if ($order == 'popular-asc') {

          $subgoals = Subgoal::with('goal')
            ->join('goals', 'subgoals.goal_id', '=', 'goals.id')
            ->where('user_id', $user->id)
            ->orderBy('goals.subgoals_count', 'ASC')
            ->get();

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

    /* Is this being used anymore? */

    public function view(Subgoal $subgoal) {

        $goal = $subgoal->goal;

        return view('subgoals.view')->with([
            //'subgoal' => $subgoal,
            'goal' => $goal,
        ]);

    }

    public function apiView($slug) {

      //Need some kind of auth for the slug here
      $user = Auth::user();

      $subgoal = Subgoal::where('user_id', $user->id)
        ->where('slug', $slug)
        ->first();


      return [
        'data' => [
          'subgoal' => $subgoal,
        ]
      ];

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
