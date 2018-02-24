<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subgoal;
use App\Goal;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubgoalsSortedRequest;
use App\Http\Requests\SubgoalOwnedByUserRequest;
use App\Http\Requests\UpdateSubgoalRequest;
use App\Http\Requests\DeleteSubgoalRequest;

class SubgoalController extends Controller {

  public function index() {
    return view('subgoals.index');
  }

  public function apiIndex() {

    $user = Auth::user();
    $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();

    return [
      'data' => [
        'subgoals' => $subgoals,
      ],
    ];

  }

  public function apiSorted(SubgoalsSortedRequest $request, $order) {

    $user = Auth::user();


    if ($order == 'cost-desc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'desc')->get();
    } else if ($order == 'cost-asc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('cost', 'asc')->get();
    } else if ($order == 'hours-desc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'desc')->get();
    } else if ($order == 'hours-asc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('hours', 'asc')->get();
    } else if ($order == 'days-desc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'desc')->get();
    } else if ($order == 'days-asc') {
      $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->orderBy('days', 'asc')->get();
    } else if ($order == 'popular-desc') {
      $subgoals = Subgoal::with('goal')
        ->join('goals', 'subgoals.goal_id', '=', 'goals.id')
        ->where('user_id', $user->id)
        ->orderBy('goals.subgoals_count', 'DESC')
        ->get();
    } else if ($order == 'popular-asc') {

      $subgoals = Subgoal::with('goal')
        ->join('goals', 'subgoals.goal_id', '=', 'goals.id')
        ->where('user_id', $user->id)
        ->orderBy('goals.subgoals_count', 'ASC')
        ->get();

    } else {
      //Else do nothing
      //Request validation should stop this condition from happening
      $subgoals = false;
      //$subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();
    }


    return [
      'data' => [
        'subgoals' => $subgoals,
      ],
    ];

  }

  public function apiView(SubgoalOwnedByUserRequest $request, $slug) {

    $user = Auth::user();

    $subgoal = Subgoal::where('user_id', $user->id)
      ->where('slug', $slug)
      ->first();

    return [
      'data' => [
        'subgoal' => $subgoal,
      ],
    ];

  }

  public function apiUpdate(UpdateSubgoalRequest $request, Subgoal $subgoal) {

    $subgoal->cost = $request->cost;
    $subgoal->hours = $request->hours;
    $subgoal->days = $request->days;
    $subgoal->save();

    $subgoal->goal->updateGoalAverages();

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }

  public function apiDelete(DeleteSubgoalRequest $request, Subgoal $subgoal) {

    //REALLY need authentication here
    //Require that subgoal is owned by user editing it

    $goal_id = $subgoal->goal->id;

    $subgoal->forceDelete();

    Goal::find($goal_id)->updateGoalAverages();

    return [
      'data' => [
        'success' => true,
      ],
    ];

  }


}
