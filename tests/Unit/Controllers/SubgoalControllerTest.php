<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;
use App\Goal;
use App\User;
use Illuminate\Support\Facades\Auth;

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
    $this->canOnlyBeViewedBy('auth', 'GET', '/api/subgoals/sort/cost-desc');
  }

  /** @test */
  public function api_sorted_invalid_slug_is_404() {

    $this->createBaseUser();
    $this->be($this->user);

    $response1 = $this->get('api/subgoals/sort/cost-desc/');
    $response2 = $this->get('api/subgoals/sort/not8valid$slug/');

    $response1->assertStatus(200);
    $response2->assertStatus(404);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_cost_desc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/cost-desc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertGreaterThanOrEqual($subgoals[1]->cost, $subgoals[0]->cost);
    $this->assertGreaterThanOrEqual($subgoals[2]->cost, $subgoals[1]->cost);
    $this->assertGreaterThanOrEqual($subgoals[3]->cost, $subgoals[2]->cost);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_cost_asc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/cost-asc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertLessThanOrEqual($subgoals[1]->cost, $subgoals[0]->cost);
    $this->assertLessThanOrEqual($subgoals[2]->cost, $subgoals[1]->cost);
    $this->assertLessThanOrEqual($subgoals[3]->cost, $subgoals[2]->cost);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_hours_desc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/hours-desc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertGreaterThanOrEqual($subgoals[1]->hours, $subgoals[0]->hours);
    $this->assertGreaterThanOrEqual($subgoals[2]->hours, $subgoals[1]->hours);
    $this->assertGreaterThanOrEqual($subgoals[3]->hours, $subgoals[2]->hours);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_hours_asc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/hours-asc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertLessThanOrEqual($subgoals[1]->hours, $subgoals[0]->hours);
    $this->assertLessThanOrEqual($subgoals[2]->hours, $subgoals[1]->hours);
    $this->assertLessThanOrEqual($subgoals[3]->hours, $subgoals[2]->hours);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_days_desc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/days-desc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertGreaterThanOrEqual($subgoals[1]->days, $subgoals[0]->days);
    $this->assertGreaterThanOrEqual($subgoals[2]->days, $subgoals[1]->days);
    $this->assertGreaterThanOrEqual($subgoals[3]->days, $subgoals[2]->days);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_days_asc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/days-asc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;

    $this->assertLessThanOrEqual($subgoals[1]->days, $subgoals[0]->days);
    $this->assertLessThanOrEqual($subgoals[2]->days, $subgoals[1]->days);
    $this->assertLessThanOrEqual($subgoals[3]->days, $subgoals[2]->days);

  }


  /** @test */
  public function api_sorted_returns_subgoals_in_popular_desc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $users = factory(User::class, 3)->create();

    $this->be($users[0]);
    $goals[0]->createDefaultSubgoal();
    $goals[1]->createDefaultSubgoal();
    $goals[2]->createDefaultSubgoal();

    $this->be($users[1]);
    $goals[0]->createDefaultSubgoal();
    $goals[1]->createDefaultSubgoal();

    $this->be($users[2]);
    $goals[0]->createDefaultSubgoal();


    //Make sure that all goal information is updated
    $all = Goal::all();

    $all->each(function($g) {
        $g->updateGoalAverages();
    });


    $this->be($this->user);

    $response = $this->json('GET', 'api/subgoals/sort/popular-desc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;


    $this->assertGreaterThanOrEqual($subgoals[1]->subgoals_count, $subgoals[0]->subgoals_count);
    $this->assertGreaterThanOrEqual($subgoals[2]->subgoals_count, $subgoals[1]->subgoals_count);
    $this->assertGreaterThanOrEqual($subgoals[3]->subgoals_count, $subgoals[2]->subgoals_count);

  }

  /** @test */
  public function api_sorted_returns_subgoals_in_popular_asc() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();


    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $users = factory(User::class, 3)->create();

    $this->be($users[0]);
    $goals[0]->createDefaultSubgoal();
    $goals[1]->createDefaultSubgoal();
    $goals[2]->createDefaultSubgoal();

    $this->be($users[1]);
    $goals[0]->createDefaultSubgoal();
    $goals[1]->createDefaultSubgoal();

    $this->be($users[2]);
    $goals[0]->createDefaultSubgoal();


    //Make sure that all goal information is updated
    $all = Goal::all();

    $all->each(function($g) {
        $g->updateGoalAverages();
    });


    $this->be($this->user);

    $response = $this->json('GET', 'api/subgoals/sort/popular-asc');
    $jsonContent = json_decode($response->getContent());

    $subgoals = $jsonContent->data->subgoals;


    $this->assertLessThanOrEqual($subgoals[1]->subgoals_count, $subgoals[0]->subgoals_count);
    $this->assertLessThanOrEqual($subgoals[2]->subgoals_count, $subgoals[1]->subgoals_count);
    $this->assertLessThanOrEqual($subgoals[3]->subgoals_count, $subgoals[2]->subgoals_count);

  }

  /** @test */
  public function api_sorted_with_other_string_still_returns_default_subgoals() {

    $this->createBaseUser();
    $this->be($this->user);

    $goals = factory(Goal::class, 4)->create();

    foreach ($goals as $goal) {
      $goal->createDefaultSubgoal();
    }

    $response = $this->json('GET', 'api/subgoals/sort/something-else');

    $response->assertJson([
      'data' => [
        'subgoals' => []
      ]
    ]);

    $jsonContent = json_decode($response->getContent());
    $length = sizeof($jsonContent->data->subgoals);

    $this->assertEquals($length, 4);

  }


  /** @test */
  public function api_update_requires_authorized_user() {

    $this->markTestSkipped('come back to this');

    $this->createBaseGoalWithSubgoal();

    //$this->canOnlyBeViewedBy('use-existing', 'POST', 'api/subgoals/' . $this->subgoal->id );

    //Need to manually test all of this because creating base subgoal then causes this to 'be' the user
    //Might need to manually test this whole situation

  }


}

