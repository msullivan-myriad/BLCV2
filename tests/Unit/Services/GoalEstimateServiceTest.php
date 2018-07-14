<?php

namespace Tests\Unit;

use App\Services\GoalEstimateService;
use App\Goal;
use App\Subgoal;
use Tests\TestCase;

class GoalEstimateServiceTest extends TestCase {

    /** @test */
    public function returns_a_base_estimate_if_goal_has_no_experiences() {

      $this->createBaseGoal();
      $this->createBaseUser();

      $subgoal1 = new Subgoal();
      $subgoal1->user_id = $this->user->id;
      $subgoal1->goal_id = $this->goal->id;
      $subgoal1->name = 'Test Goal Name';
      $subgoal1->slug = 'test-goal-name';
      $subgoal1->cost = 0;
      $subgoal1->days = 1;
      $subgoal1->hours = 30;
      $subgoal1->save();

      $subgoal2 = new Subgoal();
      $subgoal2->user_id = $this->user->id;
      $subgoal2->goal_id = $this->goal->id;
      $subgoal2->name = 'Test Goal Name';
      $subgoal2->slug = 'test-goal-name';
      $subgoal2->cost = 10;
      $subgoal2->days = 3;
      $subgoal2->hours = 20;
      $subgoal2->save();

      $goalEstimateService = new GoalEstimateService($this->goal->id);
      $goalEstimateService->updateGoalEstimate();

      $goal = Goal::find($this->goal->id);

      $this->assertEquals(5, $goal->cost);
      $this->assertEquals(2, $goal->days);
      $this->assertEquals(25, $goal->hours);

    }

    /** @test */
    public function averages_are_split_between_experience_and_votes_if_equal_number_of_each() {

      $this->createBaseGoalAndUserWithExperienceAndVote();

      $subgoal1 = new Subgoal();
      $subgoal1->user_id = $this->user->id;
      $subgoal1->goal_id = $this->goal->id;
      $subgoal1->name = 'Test Goal Name';
      $subgoal1->slug = 'test-goal-name';
      $subgoal1->cost = 0;
      $subgoal1->days = 2;
      $subgoal1->hours = 30;
      $subgoal1->save();

      $goalEstimateService = new GoalEstimateService($this->goal->id);
      $goalEstimateService->updateGoalEstimate();

      $goal = Goal::find($this->goal->id);

      $this->assertEquals(5, $goal->cost);
      $this->assertEquals(6, $goal->days);
      $this->assertEquals(20, $goal->hours);

    }

}
