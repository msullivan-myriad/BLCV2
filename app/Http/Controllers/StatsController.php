<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subgoal;

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

    public function difficulty(Request $request) {

      //Need some validation on the numbers here or things will break
      $user = Auth::user();
      $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();
      //$subgoals = $user->subgoals;

      $per_hour = $request->costPerHour;
      $per_day = $request->costPerDay;

      $new_subgoals = [];

      foreach ($subgoals as $goal) {

        $daysSum = $goal->days * $per_day;
        $hoursSum = $goal->hours * $per_hour;

        $goal->difficultySum = $goal->cost + $daysSum + $hoursSum;
        array_push($new_subgoals, $goal);

      }

      usort($new_subgoals, function($a, $b) {
          return $a->difficultySum < $b->difficultySum;
      });

      return [
        'data' => [
          'per_hour' => $per_hour,
          'per_day' => $per_day,
          'subgoals' => $subgoals,
          'new_subgoals' => $new_subgoals,
        ]
      ];

    }

}
