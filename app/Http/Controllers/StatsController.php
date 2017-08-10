<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function index() {
        return view('stats');
    }

    public function base() {

        $user = Auth::user();
        $subgoals = $user->subgoals;
        $total_goals = $subgoals->count();
        $total_cost = $subgoals->sum('cost');
        $total_days = $subgoals->sum('days');
        $total_hours = $subgoals->sum('hours');

        return [
            'data' => [
                'total_goals' => $total_goals,
                'total_cost' => $total_cost,
                'total_days' => $total_days,
                'total_hours' => $total_hours,
            ]
        ];

    }

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

}
