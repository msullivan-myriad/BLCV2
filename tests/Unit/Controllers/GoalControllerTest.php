<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalControllerTest extends TestCase {

    use DatabaseTransactions;

    private $testGoal;

    private function canBeViewedByAnyone($url) {
        $response = $this->get($url);
        $response->assertStatus(200);
    }

    private function canOnlyBeViewedByAdmin($url) {

      //I think the thought process is right here, but it probably only makes sense for get requests
      $request = $this->post($url);
      $request->assertStatus(302);

      $user = factory(User::class, 'admin')->create();

      $secondRequest = $this->actingAs($user)->post($url);
      $secondRequest->assertStatus(200);

    }

    private function createTestGoal() {
      $this->testGoal = factory(Goal::class, 'base-test-goal')->create();
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

      factory(Goal::class, 5)->create();
      $this->createTestGoal();

      $request = $this->get('api/search?search=Test Goal Name');
      $jsonAsArray = json_decode($request->getContent());

      $this->assertEquals($this->testGoal->id, $jsonAsArray[0]->id);
    }

    /** @test */
    public function api_tag_requires_admin_user() {

      $this->createTestGoal();

      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';

      $request = $this->post($url, ['tag_name' => 'filler']);
      $request->assertStatus(302);

      $user = factory(User::class, 'admin')->create();

      $secondRequest = $this->actingAs($user)->post($url, ['tag_name' => 'filler']);
      $secondRequest->assertStatus(200);

    }

    /** @test */
    public function api_tag_only_allows_properly_formatted_tag_names() {
      //Need this test still
      $this->assertTrue(true);
    }

    /** @test */
    public function api_tag_returns_the_proper_json_response() {
      //Need this test still
      $this->assertTrue(true);
    }


    //Possibly test that attaching tag to goal that doesn't exist breaks

}
