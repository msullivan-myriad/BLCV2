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
}
