<?php

namespace App\Services;

use App\Goal;

class GoalEstimateService {

  private $goal;
  private $experienceWeight;
  private $subgoalWeight;

  function __construct($goalId) {
    $this->goal = Goal::find($goalId);
  }

  //Updates the goal estimate values
  public function updateGoalEstimate() {
    $this->goal->subgoals_count = $this->goal->subgoals->count();
    $this->goal->cost = round($this->goal->subgoals->avg('cost'));
    $this->goal->days = round($this->goal->subgoals->avg('days'));
    $this->goal->hours = round($this->goal->subgoals->avg('hours'));
    $this->goal->save();
  }

  public function setGoalEstimateExperienceAndSubgoalWeights() {
    return 'Something';
  }


}