<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subgoal;
use App\Goal;
use App\Tag;
use Carbon\Carbon;

class StatsController extends Controller {

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

    $average_cost = round($total_cost / $total_goals);
    $average_days = round($total_days / $total_goals);
    $average_hours = round($total_hours / $total_goals);

    return [
      'data' => [
        'total_goals' => $total_goals,
        'total_cost' => $total_cost,
        'total_days' => $total_days,
        'total_hours' => $total_hours,

        'average_cost' => $average_cost,
        'average_days' => $average_days,
        'average_hours' => $average_hours,
      ],
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
    //$profile_age = $profile->age;

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
        //'profile_age' => $profile_age,

        //Number of years it will take using profile per year information
        'cost_years' => round($total_cost / $profile_cost, 1),
        'days_years' => round($total_days / $profile_days, 1),
        'hours_years' => round($total_hours / $profile_hours, 1),

        //Convert the numbers into rounded month format
        //Might need to consider just keeping it at years and dealing with the decimal, this might make more sense depending on the graph system I decide on
        'cost_years_in_months' => round($total_cost / $profile_cost * 365.25 / 30.4375),
        'days_years_in_months' => round($total_days / $profile_days * 365.25 / 30.4375),

      ],
    ];

  }

  public function mostAndLeastDifficult() {

    $user = Auth::user();
    $profile = $user->profile;

    $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();


    $new_subgoals = [];

    foreach ($subgoals as $goal) {

      $costPercentage = $goal->cost / $profile->cost_per_year;
      $daysPercentage = $goal->days / $profile->days_per_year;
      $hoursPercentage = $goal->hours / $profile->hours_per_year;


      $goal->difficultyPercentageSum = $costPercentage + $daysPercentage + $hoursPercentage;

      array_push($new_subgoals, $goal);

    }

    usort($new_subgoals, function ($a, $b) {
      return $a->difficultyPercentageSum < $b->difficultyPercentageSum;
    });


    return [
      'data' => [
        'subgoals' => $new_subgoals,
      ],

    ];

  }

  public function targetCompletionAge($age) {

    //Need auth with age here

    $user = Auth::user();
    $profile = $user->profile;
    //$yearsLeft = $age - $profile->age;
    $user_birthday = Carbon::parse($profile->birthday);
    $now = Carbon::now();
    $current_age_in_days = $now->diffInDays($user_birthday);
    $completion_age_days = round(($age * 365.25));

    $yearsLeft = ($completion_age_days - $current_age_in_days) / 365;

    $subgoals = $user->subgoals;
    $total_cost = $subgoals->sum('cost');
    $total_days = $subgoals->sum('days');
    $total_hours = $subgoals->sum('hours');

    $cost_per_year = round($total_cost / $yearsLeft, 0);
    $days_per_year = round($total_days / $yearsLeft, 0);
    $hours_per_year = round($total_hours / $yearsLeft, 0);


    return [
      'data' => [
        'cost_per_year' => $cost_per_year,
        'days_per_year' => $days_per_year,
        'hours_per_year' => $hours_per_year,
      ],
    ];
  }

  public function individualGoalStats($slug) {

    //Need some kind of auth for the slug here
    $user = Auth::user();

    $subgoals = $user->subgoals;

    $total_goals = $subgoals->count();

    $total_cost = $subgoals->sum('cost');
    $total_days = $subgoals->sum('days');
    $total_hours = $subgoals->sum('hours');

    $subgoal = Subgoal::where('user_id', $user->id)
      ->where('slug', $slug)
      ->first();

    $cost_percentage = round(($subgoal->cost / $total_cost) * 100, 0);
    $hours_percentage = round(($subgoal->hours / $total_hours) * 100, 0);
    $days_percentage = round(($subgoal->days / $total_days) * 100, 0);

    //Total number of subgoals for calculations below
    $subgoals_total = $subgoals->count();


    //Figure out how many goals cost less than this one
    $cost_subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'asc')->get();

    $cost_goals_larger_than = 0;

    foreach ($cost_subgoals as $cost_goal) {

      if ($cost_goal->id == $subgoal->id) {
        break;
      }

      $cost_goals_larger_than++;

    }

    //Figure out how many goals have less days than this one
    $days_subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'asc')->get();

    $days_goals_larger_than = 0;

    foreach ($days_subgoals as $days_goal) {

      if ($days_goal->id == $subgoal->id) {
        break;
      }

      $days_goals_larger_than++;

    }

    //Figure out how many goals have less hours than this one
    $hours_subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'asc')->get();

    $hours_goals_larger_than = 0;

    foreach ($hours_subgoals as $hours_goal) {

      if ($hours_goal->id == $subgoal->id) {
        break;
      }

      $hours_goals_larger_than++;

    }


    return [
      'data' => [
        'subgoal' => $subgoal,
        'cost_percentage' => $cost_percentage,
        'hours_percentage' => $hours_percentage,
        'days_percentage' => $days_percentage,
        'percentage_more_cost' => round(($cost_goals_larger_than / $subgoals_total) * 100, 0),
        'percentage_more_days' => round(($days_goals_larger_than / $subgoals_total) * 100, 0),
        'percentage_more_hours' => round(($hours_goals_larger_than / $subgoals_total) * 100, 0),
      ],
    ];

  }

  public function getAllUsersTags() {

    $user = Auth::user();

    $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();

    //Create an array of all the goal ids associated with the users subgoals
    $goal_ids_array = [];

    foreach ($subgoals as $sub) {
      array_push($goal_ids_array, $sub->goal->id);
    }

    //Get all tags with a goal id in the goal_ids_array
    $tags = Tag::whereHas('goals', function ($query) use ($goal_ids_array) {
      $query->whereIn('goal_id', $goal_ids_array);
    })->orderBy('count', 'desc')->get();

    return [
      'tags' => $tags,
    ];
  }

  public function getUsersIndividualTag(Tag $tag) {

    $user = Auth::user();
    $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();

    //Create an array of all the goal ids associated with the users subgoals
    $goal_ids_array = [];

    foreach ($subgoals as $sub) {
      array_push($goal_ids_array, $sub->goal->id);
    }

    //Get goals that have a tag id equal to the current tag id and are also in the goal_ids_array
    $tagGoals = Goal::whereHas('tags', function ($query) use ($tag, $goal_ids_array) {
      $query->where('tag_id', $tag->id)->whereIn('goal_id', $goal_ids_array);
    })->get();


    //Create an array of all tag goals to use for the whereIn statement below
    $tg_ids_array = [];

    foreach ($tagGoals as $tg) {
      array_push($tg_ids_array, $tg->id);
    }

    //Get subgoals associated with user also found in the
    $tagSubgoals = Subgoal::where('user_id', $user->id)->whereIn('goal_id', $tg_ids_array)->with('goal')->get();

    //Get totals for tag subgoals
    $tagSubgoalsCount = $tagSubgoals->count();
    $tagSubgoalsCost = $tagSubgoals->sum('cost');
    $tagSubgoalsDays = $tagSubgoals->sum('days');
    $tagSubgoalsHours = $tagSubgoals->sum('hours');

    //Get totals for all subgoals
    $subgoalsCount = $subgoals->count();
    $subgoalsCost = $subgoals->sum('cost');
    $subgoalsHours = $subgoals->sum('hours');
    $subgoalsDays = $subgoals->sum('days');

    return [
      'tag_subgoals' => $tagSubgoals,
      'tag_subgoals_count' => $tagSubgoalsCount,
      'tag_subgoals_cost' => $tagSubgoalsCost,
      'tag_subgoals_days' => $tagSubgoalsDays,
      'tag_subgoals_hours' => $tagSubgoalsHours,

      'subgoals_count' => $subgoalsCount,
      'subgoals_cost' => $subgoalsCost,
      'subgoals_hours' => $subgoalsHours,
      'subgoals_days' => $subgoalsDays,

    ];


  }

  public function individualGoalGeneralStats($slug) {

    $goal = Goal::where('slug', $slug)->with('subgoals')->first();
    $tags = $goal->tags;

    $goalCountArray = [];
    $costArray = [];
    $daysArray = [];
    $hoursArray = [];

    $currentCount = 1;

    $costTotal = 0;
    $daysTotal = 0;
    $hoursTotal = 0;

    foreach ($goal->subgoals as $subgoal) {

      $createdAt = Carbon::parse($subgoal->created_at);

      $costData = new \stdClass();
      $hoursData = new \stdClass();
      $daysData = new \stdClass();
      $goalCountData = new \stdClass();

      $costData->Date = $createdAt->month . '/' . $createdAt->day . '/' . $createdAt->year;
      $hoursData->Date = $createdAt->month . '/' . $createdAt->day . '/' . $createdAt->year;
      $daysData->Date = $createdAt->month . '/' . $createdAt->day . '/' . $createdAt->year;
      $goalCountData->Date = $createdAt->month . '/' . $createdAt->day . '/' . $createdAt->year;

      $costTotal += $subgoal->cost;
      $hoursTotal += $subgoal->hours;
      $daysTotal += $subgoal->days;

      $costData->Cost = round($costTotal / $currentCount);
      $hoursData->Hours = round($hoursTotal / $currentCount);
      $daysData->Days = round($daysTotal / $currentCount);
      $goalCountData->Goals = $currentCount;

      array_push($costArray, $costData);
      array_push($hoursArray, $hoursData);
      array_push($daysArray, $daysData);
      array_push($goalCountArray, $goalCountData);

      $currentCount++;

    }


    //Remove the duplicates dates from the goalCountArray
    $lastGoalDate = '';
    $newGoalCountArray = [];

    foreach ($goalCountArray as $goal) {

      if ($goal->Date != $lastGoalDate) {
        array_push($newGoalCountArray, $goal);
      }

      $lastGoalDate = $goal->Date;

    }

    //Remove the duplicates dates from the costArray
    $lastGoalDate = '';
    $newCostArray = [];

    foreach ($costArray as $goal) {

      if ($goal->Date != $lastGoalDate) {
        array_push($newCostArray, $goal);
      }

      $lastGoalDate = $goal->Date;

    }

    //Remove the duplicates dates from the daysArray
    $lastGoalDate = '';
    $newDaysArray = [];

    foreach ($daysArray as $goal) {

      if ($goal->Date != $lastGoalDate) {
        array_push($newDaysArray, $goal);
      }

      $lastGoalDate = $goal->Date;

    }

    //Remove the duplicates dates from the hoursArray
    $lastGoalDate = '';
    $newHoursArray = [];

    foreach ($hoursArray as $goal) {

      if ($goal->Date != $lastGoalDate) {
        array_push($newHoursArray, $goal);
      }

      $lastGoalDate = $goal->Date;

    }

    //Start a loop here, continue... something like if length is greater than or equal to 35 then remove every other value.
    //Between 17 and 35 seems like a really good number of values for these

    //I'm a little bit concerned down the line with the count data.. For example, it works great if goals are added every day,
    //But if not the dates won't increase linearly... there will be potential gaps, but the data will still display as though it
    //Is linear


    return [
      'goal_count_data' => $newGoalCountArray,
      'cost_array' => $newCostArray,
      'days_array' => $newDaysArray,
      'hours_array' => $newHoursArray,
      'goal' => $goal,
      'tags' => $tags,
    ];

  }

}
