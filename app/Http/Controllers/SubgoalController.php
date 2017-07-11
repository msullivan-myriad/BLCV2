<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subgoal;
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

}
