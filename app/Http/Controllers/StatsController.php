<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function index() {
        return view('stats');
    }

    public function totals() {

        $user = Auth::user();

        $subgoals = $user->subgoals;
        $total_goals = $subgoals->count();
        $total_cost = $subgoals->sum('cost');
        $total_days = $subgoals->sum('days');
        $total_hours = $subgoals->sum('hours');

        $average_cost = round($total_cost/$total_goals);
        $average_days = round($total_days/$total_goals);
        $average_hours = round($total_hours/$total_goals);

        return [
            'data' => [
                'total_goals' => $total_goals,
                'total_cost' => $total_cost,
                'total_days' => $total_days,
                'total_hours' => $total_hours,

                'average_cost' => $average_cost,
                'average_days' => $average_days,
                'average_hours' => $average_hours,
            ]
        ];

    }

    public function difficulty() {

      //Maybe show these number for the average American here so people have a baseline which is easier for them
      //Average discresionary income ~10000
      //Average vacation time 10
      //Average spare time per day

      //Is this really the best way to do this??




      return 'test';
    }

    /*
    public function topFives() {
        $user = Auth::user();
        $subgoals = $user->subgoals;
        $most_cost = $subgoals->sortByDesc('cost')->values()->take(5);
        $most_days = $subgoals->sortByDesc('days')->values()->take(5);
        $most_hours = $subgoals->sortByDesc('hours')->values()->take(5);

        return [

            'data' => [
                'most_cost' => $most_cost,
                'most_days' => $most_days,
                'most_hours' => $most_hours,
            ]
        ];
    }
    */

}
