<?php

namespace Tests\Unit;

use App\Goal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalControllerTest extends TestCase {

    use DatabaseTransactions;

    /** @test */
    public function index_can_be_viewed_by_anyone() {
      $response = $this->get('goals');
      $response->assertStatus(200);
    }

    /** @test */
    public function individual_goal_can_be_viewed_by_anyone() {
      factory(Goal::class, 'base-test-goal')->create();
      $response = $this->get('goal/test-goal-name');
      $response->assertStatus(200);
    }

}
