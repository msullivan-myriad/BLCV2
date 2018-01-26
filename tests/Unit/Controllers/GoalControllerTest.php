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

    /** @test */
    public function api_index_can_be_viewed_by_anyone() {
      $response = $this->get('api/goals');
      $response->assertStatus(200);
    }

    /** @test */
    public function api_index_returns_all_goals() {

      factory(Goal::class, 5)->create();

      $response = $this->get('api/goals');
      $jsonAsArray = json_decode($response->getContent());
      $jsonGoalsCount = sizeof($jsonAsArray->data->all_goals);
      $this->assertEquals(5, $jsonGoalsCount);
    }

}
