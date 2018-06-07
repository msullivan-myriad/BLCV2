<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller {

  public function viewGoalsExperiences(Goal $goal) {
    return $goal->experiences()->get();
  }

  public function addNewExperienceToGoal(Request $request) {
    return new JsonResponse('test', 200);
  }

  /*
  public function editExperience(Request $request, Experience $experience) {
    return true;
  }

  public function voteOnExperience(Request $request, Experience $xperience) {
    return true;
  }
  */

}
