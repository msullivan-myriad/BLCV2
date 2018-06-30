<?php

namespace Tests\Unit;

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
            'goal_id' => $this->goal->id,
            'user_id' => $this->user->id,
            'all_votes' => [],
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

      $this->post('api/experiences/' . $this->goal->id, [
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

      $this->canOnlyBeViewedBy('use-alternate','POST', 'api/experience/' . $this->experience->id . '/upvote' );


    }

    /** @test */
    public function upvote_experience_successfully_upvotes_experience() {

      $this->createBaseGoalAndUserWithExperience();

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'votes' => 0,
          'all_votes' => [],
        ]
      ]);

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->post('api/experience/' . $this->experience->id. '/upvote');

      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'votes' => 1,
          'all_votes' => [
            [
              'vote' => 1,
            ],
          ],
        ]
      ]);

    }

    /** @test */
    public function upvote_experience_has_additional_validation_rules() {

      $this->createBaseGoalAndUserWithExperience();

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'votes' => 0,
          'all_votes' => [],
        ]
      ]);

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->post('api/experience/' . $this->experience->id . '/upvote');


      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'votes' => 1,
          'all_votes' => [
            [
              'vote' => 1,
            ],
          ],
        ]
      ]);

      $postRequest = $this->post('api/experience/' . $this->experience->id . '/upvote');

      $postRequest->assertStatus(403);

      $response3 = $this->get('api/experiences/' . $this->goal->id);


      $response3->assertJson([
        [
          'votes' => 1,
          'all_votes' => [
            [
              'vote' => 1,
            ],
          ],
        ]
      ]);

    }


    /** @test */
    public function downvote_experience_requires_validation() {

      $this->createBaseGoalAndUserWithExperience();

      $this->createAlternateUser();

      $this->canOnlyBeViewedBy('use-alternate','POST', 'api/experience/' . $this->experience->id . '/downvote' );


    }

    /** @test */
    public function downvote_experience_successfully_downvotes_experience() {

      $this->createBaseGoalAndUserWithExperience();

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'votes' => 0,
          'all_votes' => [],
        ]
      ]);

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->post('api/experience/' . $this->experience->id. '/downvote');

      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'votes' => -1,
          'all_votes' => [
            [
              'vote' => -1,
            ]
          ],
        ]
      ]);

    }


    /** @test */
    public function downvote_experience_has_additional_validation_rules() {

      $this->createBaseGoalAndUserWithExperience();

      $response = $this->get('api/experiences/' . $this->goal->id);

      $response->assertJson([
        [
          'votes' => 0,
          'all_votes' => [],
        ]
      ]);

      $this->createAlternateUser();
      $this->be($this->alternateUser);

      $this->post('api/experience/' . $this->experience->id . '/downvote');


      $response2 = $this->get('api/experiences/' . $this->goal->id);

      $response2->assertJson([
        [
          'votes' => -1,
          'all_votes' => [
            [
              'vote' => -1,
            ]
          ],
        ]
      ]);

      $postRequest = $this->post('api/experience/' . $this->experience->id . '/downvote');

      $postRequest->assertStatus(403);

      $response3 = $this->get('api/experiences/' . $this->goal->id);


      $response3->assertJson([
        [
          'votes' => -1,
          'all_votes' => [
            [
              'vote' => -1,
            ]
          ],
        ]
      ]);

    }

    /* Next up.....

    1) This a slight hangup here, with the logic around downvoting an experience that is already upvoted (un-upvoting & un-downvoting)
    2) Add some upvotes and experiences using the seeder
    3) Goal values are calculated based upon experiences + other goals (ask Erin about this.... she said she likes the idea of it happening incrementally based on more experiences)
    4) Need to reevaluate how data is being passed down on the MainGoalPage
    5) Need to create limit that people cannot add more than one experience

    */

}
