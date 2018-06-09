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

      $this->createBaseGoal();
      $this->canOnlyBeViewedBy('auth','POST', 'api/experiences/' . $this->goal->id, [
        'cost' => 100,
        'days' => 100,
        'hours' => 100,
        'text' => 'Text here',
      ]);

    }

    /** @test */
    public function add_new_experience_successfully_attaches_to_goal() {
      $this->createBaseGoal();
      $this->createBaseUser();
      $this->be($this->user);

      $test = $this->post('api/experiences/' . $this->goal->id, [
        'cost' => 100,
        'days' => 100,
        'hours' => 100,
        'text' => 'This is some text about the experience',
      ]);


      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [

          'cost' => 100,
          'days' => 100,
          'hours' => 100,
          'text' => 'This is some text about the experience',

        ]

      ]);

    }

    /** @test */
    public function edit_experience_requires_validation() {

      $this->createBaseGoalAndUserWithExperience();

      $this->canOnlyBeViewedBy('use-existing','POST', 'api/experience/' . $this->experience->id . '/edit', [
        'cost' => 100,
        'days' => 100,
        'hours' => 100,
        'text' => 'Text here',
      ]);

    }

    /** @test */
    public function edit_experience_successfully_edits_experience() {

      $this->createBaseGoalAndUserWithExperience();
      $this->be($this->user);

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'cost' => 10,
          'days' => 10,
          'hours' => 10,
          'text' => 'Test Experience Text',
        ]

      ]);

      $this->post('api/experience/' . $this->experience->id . '/edit', [
        'cost' => 100,
        'days' => 100,
        'hours' => 100,
        'text' => 'Text here',
      ]);

      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'cost' => 100,
          'days' => 100,
          'hours' => 100,
          'text' => 'Text here',
        ]
      ]);

    }

    /** @test */
    public function upvote_experience_requires_validation() {

      $this->createBaseGoalAndUserWithExperience();

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->canOnlyBeViewedBy('use-existing','POST', 'api/experience/' . $this->experience->id . '/upvote' );


    }

    /** @test */
    public function upvote_experience_has_additional_validation_rules() {

      $this->markTestSkipped();

    }

    /** @test */
    public function upvote_experience_successfully_upvotes_experience() {

      $this->createBaseGoalAndUserWithExperience();

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'votes' => 10,
        ]
      ]);

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->post('api/experience/' . $this->experience->id. '/upvote');

      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'votes' => 11,
        ]
      ]);

    }

    /** @test */
    public function downvote_experience_requires_validation() {

      $this->markTestSkipped();

    }

    /** @test */
    public function downvote_experience_successfully_upvotes_experience() {

      $this->markTestSkipped();

    }

}
