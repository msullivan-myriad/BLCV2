<?php

namespace Tests\Unit;

use App\Goal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalControllerTest extends TestCase {

    use DatabaseTransactions;

    private function canBeViewedByAnyone($url) {
      $response = $this->get($url);
      $response->assertStatus(200);
    }

    /** @test */
    public function index_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('goals');
    }

    /** @test */
    public function individual_goal_can_be_viewed_by_anyone() {
      factory(Goal::class, 'base-test-goal')->create();
      $this->canBeViewedByAnyone('goal/test-goal-name');
    }

    /** @test */
    public function api_index_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/goals');
    }

    /** @test */
    public function api_index_returns_all_goals() {

      factory(Goal::class, 5)->create();

      $response = $this->get('api/goals');
      $jsonAsArray = json_decode($response->getContent());
      $jsonGoalsCount = sizeof($jsonAsArray->data->all_goals);
      $this->assertEquals(5, $jsonGoalsCount);
    }

    /** @test */
    public function api_popular_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/popular');

    }

    /** @test */
    public function api_popular_is_paginated() {

      factory(Goal::class, 21)->create();

      $response = $this->get('api/popular');
      $jsonAsArray = json_decode($response->getContent());
      $popularGoals = $jsonAsArray->data->popular_goals;

      $this->assertEquals(1, $popularGoals->current_page);
      $this->assertEquals(10, $popularGoals->per_page);
      $this->assertEquals(21, $popularGoals->total);
    }

    /** @test */
    public function api_search_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/search');
    }

    /** @test */
    public function api_search_can_search_for_goals() {

    }


}
