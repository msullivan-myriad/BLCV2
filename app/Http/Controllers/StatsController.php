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

    public function completionAge() {

      $user = Auth::user();
      $profile = $user->profile;

      $subgoals = $user->subgoals;

      $total_cost = $subgoals->sum('cost');
      $total_days = $subgoals->sum('days');
      $total_hours = $subgoals->sum('hours');

      $profile_cost = $profile->cost_per_year;
      $profile_days = $profile->days_per_year;
      $profile_hours = $profile->hours_per_year;
      $profile_age = $profile->age;

      return [

        'data' => [

          //Subgoal Totals
          'total_cost' => $total_cost,
          'total_days' => $total_days,
          'total_hours' => $total_hours,

          //Profile Per Year Information
          'profile_cost' => $profile_cost,
          'profile_days' => $profile_days,
          'profile_hours' => $profile_hours,
          'profile_age' => $profile_age,

          //Number of years it will take using profile per year information
          'cost_years' => round($total_cost/$profile_cost, 1),
          'days_years' => round($total_days/$profile_days, 1),
          'hours_years' => round($total_hours/$profile_hours, 1),

          //Convert the numbers into rounded month format
          //Might need to consider just keeping it at years and dealing with the decimal, this might make more sense depending on the graph system I decide on
          'cost_years_in_months' => round($total_cost/$profile_cost*365.25/30.4375),
          'days_years_in_months' => round($total_days/$profile_days*365.25/30.4375),

        ]
      ];

    }

    /*
    public function difficulty(Request $request) {

      //Need some validation on the numbers here or things will break
      $user = Auth::user();
      $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();

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
    */

    public function mostAndLeastDifficult() {

      $user = Auth::user();
      $profile = $user->profile;

      $subgoals= Subgoal::with('goal')->where('user_id', $user->id)->get();


      $new_subgoals = [];

      foreach ($subgoals as $goal) {

        $costPercentage = $goal->cost/$profile->cost_per_year;
        $daysPercentage = $goal->days/$profile->days_per_year;
        $hoursPercentage = $goal->hours/$profile->hours_per_year;


        $goal->difficultyPercentageSum = $costPercentage + $daysPercentage + $hoursPercentage;

        array_push($new_subgoals, $goal);

      }

      usort($new_subgoals, function($a, $b) {
          return $a->difficultyPercentageSum < $b->difficultyPercentageSum;
      });


      return [
        'data' => [
          'subgoals' => $new_subgoals,
        ]

      ];

    }

}
