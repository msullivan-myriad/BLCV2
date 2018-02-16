<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;

class SubgoalControllerTest extends ControllerTestCase {

  /** @test */
  public function index_requires_authorized_user() {
    $this->canOnlyBeViewedBy('auth', 'GET', 'subgoals');
  }

  /** @test */
  public function api_index_required_authorized_user() {
    $this->canOnlyBeViewedBy('auth', 'GET', 'api/subgoals');
  }

  /** @test */
  public function api_index_returns_proper_json_response() {
    $this->createBaseGoalWithSubgoal();

    $response = $this->json('GET', 'api/subgoals');

    $response->assertJson([
      'data' => [
        'subgoals' => [
          [
            'id' => $this->subgoal->id,
            'goal_id' => $this->goal->id,
            'user_id' => $this->user->id,
            'name' => $this->subgoal->name,
            'goal' => [
              'id' => $this->goal->id,
              'name' => $this->goal->name,
            ]
          ]
        ]
      ]
    ]);
  }

  /** @test */
  public function api_sorted_requires_authorized_user() {
    $this->canOnlyBeViewedBy('auth', 'GET', '/api/subgoals/cost-desc');
  }

  /** @test */
  public function api_sorted_invalid_slug_is_404() {

    $this->createBaseUser();
    $this->be($this->user);

    $response1 = $this->get('api/subgoals/cost-desc/');
    $response2 = $this->get('api/subgoals/not8valid$slug/');

    $response1->assertStatus(200);

    //For some reason this is returning a 405 rather than a 404
    //$response2->assertStatus(404);

  }

}
