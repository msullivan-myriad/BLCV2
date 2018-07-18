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
  private $votesCount;
  private $subgoalCount;

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

    $this->setSubgoalAndVotesCount();
    $this->setGoalEstimateExperienceAndSubgoalWeights();
    $this->setSubgoalAveragesValues();
    $this->setExperienceAveragesValues();

    $this->goal->subgoals_count = $this->subgoals->count();

    //Use the calculated average values multiplied by the weight to get the overall goal estimate
    $this->goal->cost = ($this->subgoalAverages['cost'] * $this->subgoalWeight) + ($this->experienceAverages['cost'] * $this->experienceWeight);
    $this->goal->days = ($this->subgoalAverages['days'] * $this->subgoalWeight) + ($this->experienceAverages['days'] * $this->experienceWeight);
    $this->goal->hours = ($this->subgoalAverages['hours'] * $this->subgoalWeight) + ($this->experienceAverages['hours'] * $this->experienceWeight);

    $this->goal->save();
  }

  private function setSubgoalAveragesValues() {
    //Set the subgoal averages using a basic average of all subgoals
    $this->subgoalAverages['cost'] = round($this->subgoals->avg('cost'));
    $this->subgoalAverages['days'] = round($this->subgoals->avg('days'));
    $this->subgoalAverages['hours'] = round($this->subgoals->avg('hours'));
  }

  private function setExperienceAveragesValues() {

    $costAverage = 0;
    $hoursAverage = 0;
    $daysAverage = 0;

    foreach ($this->experiences as $experience) {

      $voteCount = $experience->votes()->sum('vote');
      $weight = 0;

      if ($voteCount > 0 ) {
        $weight = $voteCount/$this->votesCount;
      }

      //A weight of an experience can never be greater that 1
      //this can happen above if there are 2 downvotes and 1 upvote
      if ($weight > 1) {
        $weight = 1;
      }

      $costAverage += $experience->cost * $weight;
      $hoursAverage += $experience->hours * $weight;
      $daysAverage += $experience->days * $weight;

    }

    $this->experienceAverages['cost'] = $costAverage;
    $this->experienceAverages['days'] = $daysAverage;
    $this->experienceAverages['hours'] = $hoursAverage;

  }

  public function setGoalEstimateExperienceAndSubgoalWeights() {
    //Set the weight of subgoals and experiences that will be used when calculating the estimate, returns decimal

    $totalVotesAndSubgoalCount = $this->subgoalCount + $this->votesCount;

    $this->experienceWeight = $this->votesCount/$totalVotesAndSubgoalCount;
    $this->subgoalWeight = $this->subgoalCount/$totalVotesAndSubgoalCount;

  }

  private function setSubgoalAndVotesCount() {

    $this->subgoalCount = $this->subgoals->count();
    $this->votesCount =  0;

    foreach ($this->experiences as $experience) {
      $count = $experience->votes()->sum('vote');
      $this->votesCount += $count;
    }


    if ($this->votesCount < 0) {
      $this->votesCount = 0;
    }

  }

}