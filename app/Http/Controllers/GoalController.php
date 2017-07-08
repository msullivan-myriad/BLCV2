<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index() {

        $all_goals = Goal::all();

        return view('goals.index')->with( 'goals', $all_goals);
    }

    public function add(Goal $goal) {
        $user = Auth::user();
        $user->addGoal($goal);
        return redirect()->back();
    }

    public function create(Request $request) {

        //Need some validation here
        $user = Auth::user();
        $user->newGoal($request->title, $request->cost, $request->days, $request->hours);
        return redirect()->back();
    }

    public function view(Goal $goal) {

        $subgoals = $goal->subgoals;

        return view('goals.view')->with([
            'goal' => $goal,
            'subgoals' => $subgoals,
       ] );
    }

}
