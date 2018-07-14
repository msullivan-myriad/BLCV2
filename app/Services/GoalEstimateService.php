<?php

namespace App\Services;

use App\Goal;
use App\Vote;

class GoalEstimateService {

  private $goal;
  private $subgoals;
  private $experiences;
  private $experienceWeight;
  private $subgoalWeight;
  private $subgoalAverages;
  private $experienceAverages;

  function __construct($goalId) {

    $this->goal = Goal::find($goalId);
    $this->experiences = $this->goal->experiences()->get();
    $this->subgoals = $this->goal->subgoals()->get();

    $this->subgoalAverages['cost'] = 0;
    $this->subgoalAverages['hours'] = 0;
    $this->subgoalAverages['days'] = 0;

    $this->experienceAverages['cost'] = 0;
    $this->experienceAverages['hours'] = 0;
    $this->experienceAverages['days'] = 0;

  }

  public function updateGoalEstimate() {
    //Updates the goal estimate values


    $this->setGoalEstimateExperienceAndSubgoalWeights();
    $this->setSubgoalAveragesValues();

    $this->goal->subgoals_count = $this->subgoals->count();

    //Use the calculated average values multiplied by the weight to get the overall goal estimate
    $this->goal->cost = ($this->subgoalAverages['cost'] * $this->subgoalWeight) + ($this->experienceAverages['cost'] * $this->experienceWeight);
    $this->goal->days = ($this->subgoalAverages['days'] * $this->subgoalWeight) + ($this->experienceAverages['days'] * $this->experienceWeight);
    $this->goal->hours = ($this->subgoalAverages['hours'] * $this->subgoalWeight) + ($this->experienceAverages['hours'] * $this->experienceWeight);

    /*
    $this->goal->cost = round($this->subgoals->avg('cost'));
    $this->goal->days = round($this->subgoals->avg('days'));
    $this->goal->hours = round($this->subgoals->avg('hours'));
    */

    $this->goal->save();
  }

  private function setSubgoalAveragesValues() {
    //Set the subgoal averages using a basic average of all subgoals
    $this->subgoalAverages['cost'] = round($this->subgoals->avg('cost'));
    $this->subgoalAverages['days'] = round($this->subgoals->avg('days'));
    $this->subgoalAverages['hours'] = round($this->subgoals->avg('hours'));
  }

  private function setExperienceAveragesValues() {
    //Set the experience averages

    //Possibly make an array of all experiences and a weight based off of the total amount of votes


    $this->experienceAverages['cost'] = round($this->subgoals->avg('cost'));
    $this->experienceAverages['days'] = round($this->subgoals->avg('days'));
    $this->experienceAverages['hours'] = round($this->subgoals->avg('hours'));

  }

  public function setGoalEstimateExperienceAndSubgoalWeights() {
    //Set the weight of subgoals and experiences that will be used when calculating the estimate, returns decimal
    $subgoalCount = $this->subgoals->count();
    $votesCount =  0;

    $this->experiences->map(function($experience) {
      var_dump($experience->votes()->count());
    });

    $totalVotesAndSubgoalCount = $subgoalCount + $votesCount;

    $this->experienceWeight = $votesCount/$totalVotesAndSubgoalCount;
    $this->subgoalWeight = $subgoalCount/$totalVotesAndSubgoalCount;

  }

}