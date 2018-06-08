<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Goal;
use App\Http\Requests\AddNewExperienceToGoalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller {

  public function viewGoalsExperiences(Goal $goal) {
    return $goal->experiences()->get();
  }

  public function addNewExperienceToGoal(AddNewExperienceToGoalRequest $request, Goal $goal) {

    $experience = new Experience();

    $experience->cost = $request->cost;
    $experience->days = $request->days;
    $experience->hours = $request->hours;
    $experience->text = $request->text;
    $experience->votes = 0;


    $experience->user()->associate(Auth::user()->id);
    $experience->goal()->associate($goal);
    $experience->save();

    return new JsonResponse('success', 200);

  }

  /*
  public function editExperience(Request $request, Experience $experience) {
    return true;
  }

  public function upVoteExperience(Request $request, Experience $experience) {
    return true;
  }

  public function downVoteExperience(Request $request, Experience $experience) {
    return true;
  }
  */

}
