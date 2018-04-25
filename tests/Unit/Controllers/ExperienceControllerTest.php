<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use App\Experience;
use Tests\ControllerTestCase;

class ExperienceControllerTest extends ControllerTestCase {

    /** @test */
    public function view_goals_experiences_can_be_viewed_by_anyone() {
      $this->createBaseGoalAndUserWithExperience();
      $this->canBeViewedByAnyone('api/experiences/' . $this->goal->id);

    }

    /** @test */
    public function view_goals_experiences_returns_proper_experiences() {
      $this->createBaseGoalAndUserWithExperience();

      $request = $this->get('api/experiences/' . $this->goal->id);

      $request->assertJson([
          [
            'text' => 'Test Experience Text',
            'days' => 10,
            'hours' => 10,
            'cost' => 10,
            'votes' => 10,
            'goal_id' => $this->goal->id,
            'user_id' => $this->user->id,
          ],
       ]);


    }

    /** @test */
    public function add_new_experience_requires_validation() {
      $this->markTestSkipped();
    }

    /** @test */
    public function add_new_experience_successfully_attaches_to_goal() {
      $this->markTestSkipped();
    }

}
