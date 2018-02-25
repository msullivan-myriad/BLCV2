<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;
use App\Goal;

class StatsControllerTest extends ControllerTestCase {

  /** @test */
  public function totals_requires_authenticated_user() {

    $this->createBaseGoalWithSubgoal();
    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/totals');
  }

  /** @test */
  public function totals_returns_proper_json_response_with_no_goals() {

    $this->createBaseUser();
    $this->be($this->user);

    $response = $this->get('api/stats/totals');

    $response->assertJson([
      'data' => [
        'total_goals' => 0,
        'total_cost' => 0,
        'total_days' => 0,
        'total_hours' => 0,
        'average_cost' => 0,
        'average_days' => 0,
        'average_hours' => 0,
      ],

    ]);

  }

  /** @test */
  public function totals_returns_proper_json_response_with_calculated_data() {

    $this->createBaseUser();
    $this->be($this->user);

    Goal::newGoal('First', 0, 10, 100);
    Goal::newGoal('Second', 500, 50, 5);
    Goal::newGoal('Third', 1000, 100, 9);

    $response = $this->get('api/stats/totals');

    $response->assertJson([
      'data' => [
        'total_goals' => 3,
        'total_cost' => 1500,
        'total_days' => 114,
        'total_hours' => 160,
        'average_cost' => 500,
        'average_days' => 38,
        'average_hours' => 53,
      ],

    ]);

  }

  /** @test */
  public function completion_age_requires_authenticated_user() {

    $this->createBaseUserWithProfile();
    $this->be($this->user);
    $this->createBaseGoal();
    $this->goal->createDefaultSubgoal();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);

    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/completion-age');

  }

  /** @test */
  public function completion_age_without_profile_information_returns_proper_json_response() {

    $this->createBaseUserWithProfile();
    $this->be($this->user);
    $this->createBaseGoal();
    $this->goal->createDefaultSubgoal();
    //$this->user->profile->setDedicatedPerYear(1000, 10, 100);

    $response = $this->get('api/stats/completion-age');

    $response->assertJson([
      'test' => [],
    ]);


  }

}
