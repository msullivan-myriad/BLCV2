<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;
use App\Goal;
use App\Subgoal;
use App\User;
use Illuminate\Support\Facades\Auth;

class SubgoalControllerTest extends ControllerTestCase {

  /** @test */
  public function index_requires_authorized_user() {
    $this->canOnlyBeViewedBy('auth', 'GET', 'calculator');
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
  public function api_sorted_nonexisting_slug_is_unauthorized() {

    $this->createBaseUser();
    $this->be($this->user);

    $response1 = $this->get('api/subgoals/sort/cost-desc/');
    $response2 = $this->get('api/subgoals/sort/slug-does-not-exist/');

    $response1->assertStatus(200);
    $response2->assertStatus(403);

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
  public function api_view_requires_authorized_user() {
    $this->createBaseGoalWithSubgoal();
    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/subgoals/single/' . $this->subgoal->slug );
  }

  /** @test */
  public function api_view_nonexisting_slug_is_403() {

    $this->createBaseGoalWithSubgoal();

    $response1 = $this->get('api/subgoals/single/' . $this->subgoal->slug);
    $response2 = $this->get('api/subgoals/single/not-valid-slug/');

    $response1->assertStatus(200);
    $response2->assertStatus(403);

  }

  /** @test */
  public function api_view_requires_that_subgoal_is_owned_by_user() {

    $this->createBaseGoalWithSubgoal();

    $respsone1 = $this->get('api/subgoals/single/' . $this->subgoal->slug);
    $respsone1->assertStatus(200);

    $user = factory(User::class)->create();
    $this->be($user);

    $respsone2 = $this->get('api/subgoals/single/' . $this->subgoal->slug);
    $respsone2->assertStatus(403);

  }

  /** @test */
  public function api_view_returns_proper_json_response() {

    $this->createBaseGoalWithSubgoal();

    $response = $this->json('GET', 'api/subgoals/single/' . $this->subgoal->slug);

    $response->assertJson([
      'data' => [
        'subgoal' => [
          'id' => $this->subgoal->id,
          'name' => $this->subgoal->name,
          'slug' => $this->subgoal->slug,
          'user_id' => $this->user->id,
          'goal_id' => $this->goal->id,
        ]
      ],
    ]);
  }

  /** @test */
  public function api_update_requires_authorized_user() {

    $this->createBaseGoalWithSubgoal();

    $this->canOnlyBeViewedBy('use-existing', 'POST', 'api/subgoals/' . $this->subgoal->id, [
      'cost' => 10,
      'hours' => 5,
      'days' => 8,
    ]);

  }

  /** @test */
  public function api_update_requires_that_subgoal_is_owned_by_user() {

    $this->createBaseGoalWithSubgoal();

    $respsone1 = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => 1,
      'hours' => 1,
      'days' => 1,
    ]);

    $respsone1->assertStatus(200);

    $user = factory(User::class)->create();
    $this->be($user);

    $respsone2 = $this->get('api/subgoals/single/' . $this->subgoal->slug);
    $respsone2->assertStatus(403);

  }

  /** @test */
  public function api_update_has_validation_rules() {

    $this->createBaseGoalWithSubgoal();

    $respsone1 = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => '',
      'hours' => '',
      'days' => '',
    ]);

    $respsone1->assertStatus(302);

    $respsone2 = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => 'string',
      'hours' => 'string',
      'days' => 'string',
    ]);

    $respsone2->assertStatus(302);

    $respsone3 = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => 100000000000,
      'hours' => 1000000,
      'days' => 100000,
    ]);

    $respsone3->assertStatus(302);

    $respsone4 = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => 1000000000,
      'hours' => 10000,
      'days' => 1000,
    ]);

    $respsone4->assertStatus(200);


  }

  /** @test */
  public function api_update_returns_proper_json_response() {

    $this->createBaseGoalWithSubgoal();

    $response = $this->post('api/subgoals/' . $this->subgoal->id, [
      'cost' => 1000000000,
      'hours' => 10000,
      'days' => 1000,
    ]);

    $response->assertJson([
      'data' => [
        'success' => true,
      ]
    ]);

  }

  /** @test */
  public function api_delete_requires_authorized_user() {

    $this->createBaseGoalWithSubgoal();
    $this->canOnlyBeViewedBy('use-existing' ,'DELETE', 'api/subgoals/' . $this->subgoal->id);

  }


  /** @test */
  public function api_delete_requires_that_subgoal_is_owned_by_user() {

    $this->createBaseGoalWithSubgoal();

    $respsone1 = $this->delete('api/subgoals/' . $this->subgoal->id);

    $respsone1->assertStatus(200);

    $this->goal->createDefaultSubgoal();
    $this->subgoal = Subgoal::where('goal_id', $this->goal->id)->first();

    $user = factory(User::class)->create();
    $this->be($user);

    $respsone2 = $this->delete('api/subgoals/' . $this->subgoal->id);
    $respsone2->assertStatus(403);

  }

  /** @test */
  public function api_delete_returns_proper_json_response() {

    $this->createBaseGoalWithSubgoal();

    $response = $this->delete('api/subgoals/' . $this->subgoal->id);

    $response->assertJson([
      'data' => [
        'success' => true,
      ],
    ]);

  }

  //Try to move slug validation outside of web.php and into FormRequest validation

}

