<?php

namespace Tests\Unit;

use App\Services\GoalEstimateService;
use App\Goal;
use App\Subgoal;
use Tests\TestCase;

class GoalEstimateServiceTest extends TestCase {

    /** @test */
    public function goal_estimate_service_returns_a_base_estimate() {

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
    public function goal_estimate_service_sets_weights() {
      $this->markTestSkipped();
    }

}
