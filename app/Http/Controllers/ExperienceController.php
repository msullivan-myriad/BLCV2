<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;

class ExperienceController extends Controller {

  public function viewGoalsExperiences(Goal $goal) {
    return $goal->experiences()->get();
  }

  public function addNewExperienceToGoal(Request $request, Goal $goal) {
    return true;
  }

}
