<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\ControllerTestCase;
use App\Goal;
use App\Tag;

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

      'data' => [

        'total_cost' => 700,
        'total_days' => 10,
        'total_hours' => 100,

        'profile_cost' => 0,
        'profile_days' => 0,
        'profile_hours' => 0,

        'cost_years' => 0,
        'days_years' => 0,
        'hours_years' => 0,

        'cost_years_in_months' => 0,
        'days_years_in_months' => 0,

      ],
    ]);
  }

  /** @test */
  public function completion_age_with_profile_information_returns_proper_json_response() {

    $this->createBaseUserWithProfile();
    $this->be($this->user);
    $this->createBaseGoal();
    $this->goal->createDefaultSubgoal();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);

    $response = $this->get('api/stats/completion-age');

    $response->assertJson([

      'data' => [

        'total_cost' => 700,
        'total_days' => 10,
        'total_hours' => 100,

        'profile_cost' => 1000,
        'profile_days' => 10,
        'profile_hours' => 100,

        'cost_years' => 0.7,
        'days_years' => 1,
        'hours_years' => 1,

        'cost_years_in_months' => 8,
        'days_years_in_months' => 12,

      ],
    ]);
  }

  /** @test */
  public function most_and_least_difficult_requires_authenticated_user() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/most-and-least-difficult');

  }

  /** @test */
  public function most_and_least_difficult_requires_user_has_profile_information_filled_out() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->be($this->user);


    $response1 = $this->json('GET', 'api/stats/most-and-least-difficult');
    $response1->assertStatus(200);

    $this->user->profile->setDedicatedPerYear(1000, 10, 0);
    $response2 = $this->json('GET', 'api/stats/most-and-least-difficult');
    $response2->assertStatus(403);

    $this->user->profile->setDedicatedPerYear(1000, 0, 10);
    $response3 = $this->json('GET', 'api/stats/most-and-least-difficult');
    $response3->assertStatus(403);

    $this->user->profile->setDedicatedPerYear(0, 10, 10);
    $response4 = $this->json('GET', 'api/stats/most-and-least-difficult');
    $response4->assertStatus(403);


  }

  /** @test */
  public function most_and_least_difficult_returns_proper_json_response() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->be($this->user);

    Goal::newGoal('Test Goal 1', 1000, 10, 1);
    Goal::newGoal('Test Goal 2', 100, 5, 10);
    Goal::newGoal('Test Goal 3', 1000, 20, 100);

    $response = $this->json('GET', 'api/stats/most-and-least-difficult');

    $response->assertJson([
      'data' => [
        'most_difficult' => [

          [
            'name' => 'Test Goal 3',
            'difficultyPercentageSum' => 11.2,
          ],

          [
            'name' => 'Test Goal 1',
            'difficultyPercentageSum' => 1.2,
          ],

          [
            'name' => 'Test Goal 2',
            'difficultyPercentageSum' => 1.15,
          ],

        ],
         'least_difficult' => [

          [
            'name' => 'Test Goal 2',
            'difficultyPercentageSum' => 1.15,
          ],

          [
            'name' => 'Test Goal 1',
            'difficultyPercentageSum' => 1.2,
          ],

          [
            'name' => 'Test Goal 3',
            'difficultyPercentageSum' => 11.2,
          ],

        ],


      ],
    ]);

  }

  /** @test */
  public function target_completion_age_requires_authenticated_user() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->user->profile->setBirthday('2012-01-01');
    $this->be($this->user);
    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/target-completion-age/50');

  }

  /** @test */
  public function target_completion_age_must_be_valid_number() {
    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->user->profile->setBirthday('2000-01-01');
    $this->be($this->user);

    $response1 = $this->get('api/stats/target-completion-age/50');
    $response1->assertStatus(200);

    $response2 = $this->get('api/stats/target-completion-age/50.0');
    $response2->assertStatus(403);
  }

  /** @test */
  public function target_completion_age_must_be_greater_than_users_current_age() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->user->profile->setBirthday('2000-01-01');
    $this->be($this->user);

    $response1 = $this->get('api/stats/target-completion-age/50');
    $response1->assertStatus(200);

    $response2 = $this->get('api/stats/target-completion-age/17');
    $response2->assertStatus(403);


  }

  /** @test */
  public function target_completion_age_requires_profile_information_be_filled_out() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->user->profile->setBirthday('2000-01-01');
    $this->be($this->user);

    $response1 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response1->assertStatus(200);

    $this->user->profile->setDedicatedPerYear(1000, 10, 0);
    $response2 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response2->assertStatus(403);

    $this->user->profile->setDedicatedPerYear(1000, 0, 10);
    $response3 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response3->assertStatus(403);

    $this->user->profile->setDedicatedPerYear(0, 10, 10);
    $response4 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response4->assertStatus(403);

  }

  /** @test */
  public function target_completion_age_requires_birthday_is_present() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);
    $this->be($this->user);

    $response1 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response1->assertStatus(403);

    $this->user->profile->setBirthday('2000-01-01');


    $response2 = $this->json('GET', 'api/stats/target-completion-age/50');
    $response2->assertStatus(200);
  }

  /** @test */
  public function target_completion_age_returns_proper_json_response() {

    $this->createBaseUserWithProfile();
    $this->user->profile->setDedicatedPerYear(1000, 10, 100);

    $this->user->profile->setBirthday(Carbon::now()->subYears(10));
    $this->be($this->user);

    Goal::newGoal('Test Goal', 10000, 100, 1000);

    $response = $this->json('GET', 'api/stats/target-completion-age/20');

    $response->assertJson([
      'data' => [
        'cost_per_year' => 999,
        'days_per_year' => 100,
        'hours_per_year' => 10,
      ]
    ]);
  }

  /** @test */
  public function individual_goal_stats_requires_authorized_user() {

    $this->createBaseUser();
    $this->be($this->user);

    Goal::newGoal('Test Goal', 1000, 100, 10);

    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/individual-goal-stats/test-goal');

  }

  /** @test */
  public function individual_goal_stats_requires_slug_of_subgoal_that_belongs_to_authorized_user() {

    $this->createBaseUser();
    $this->be($this->user);

    Goal::newGoal('Test Goal', 1000, 100, 10);


    $response1 = $this->json('GET', 'api/stats/individual-goal-stats/test-goal');
    $response1->assertStatus(200);

    $response2 = $this->json('GET', 'api/stats/individual-goal-stats/not-real-goal');
    $response2->assertStatus(403);

  }

  /** @test */
  public function individual_goal_stats_returns_proper_json_response() {

    $this->createBaseUser();
    $this->be($this->user);

    Goal::newGoal('Test Goal 1', 1000, 100, 5);
    Goal::newGoal('Test Goal 2', 0, 200, 0);
    Goal::newGoal('Test Goal 3', 0, 200, 10);


    $response = $this->json('GET', 'api/stats/individual-goal-stats/test-goal-1');
    $response->assertJson([
      'data' => [
          'subgoal' => [
            'name' => 'Test Goal 1',
            'slug' => 'test-goal-1',
          ],
          'cost_percentage' => 100,
          'hours_percentage' => 20,
          'days_percentage' => 33,
          'percentage_more_cost' => 67,
          'percentage_more_days' => 33,
          'percentage_more_hours' => 0,
      ],
    ]);

  }

  /** @test */
  public function get_all_users_tags_requires_authorized_user() {

    $this->canOnlyBeViewedBy('auth', 'GET','api/stats/users-tags');

  }

  /** @test */
  public function get_all_users_tags_returns_proper_json_response_without_any_tags() {

    $this->createBaseGoalWithSubgoal();

    $response = $this->json('GET', 'api/stats/users-tags');

    $response->assertJson([
      'tags' => [],
    ]);

  }

  /** @test */
  public function get_all_users_tags_returns_proper_json_response_with_tags() {

    $this->createBaseTag();
    $this->createBaseGoalWithSubgoal();

    $this->goal->attachTagToGoal($this->tag->name);

    $response = $this->json('GET', 'api/stats/users-tags');

    $response->assertJson([
      'tags' => [
        [
          'name' => 'Test Tag',
          'slug' => 'test-tag',
          'count' => 1,
        ]
      ],
    ]);

  }

  /** @test */
  public function get_users_individual_tag_requires_authorized_user() {

    $this->createBaseTag();
    $this->createBaseGoalWithSubgoal();

    $this->goal->attachTagToGoal($this->tag->name);

    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/users-tags/' . $this->tag->id);

  }

  /** @test */
  public function get_users_individual_tag_returns_404_when_nonexistant_tag_id() {

    $this->createBaseTag();
    $this->createBaseGoalWithSubgoal();

    $this->goal->attachTagToGoal($this->tag->name);

    $response1 = $this->json('GET', 'api/stats/users-tags/' . $this->tag->id);
    $response1->assertStatus(200);

    $response2 = $this->json('GET', 'api/stats/users-tags/' . 90178);
    $response2->assertStatus(404);

  }

  /** @test */
  public function get_users_individual_tag_requires_that_user_has_at_least_one_subgoal_with_the_requested_tag() {

    $this->createBaseTag();
    $this->createBaseGoalWithSubgoal();

    $tag = factory(Tag::class)->create();

    $this->goal->attachTagToGoal($this->tag->name);

    $response1 = $this->json('GET', 'api/stats/users-tags/' . $this->tag->id);
    $response1->assertStatus(200);

    $response2 = $this->json('GET', 'api/stats/users-tags/' . $tag->id);
    $response2->assertStatus(403);

    $this->goal->attachTagToGoal($tag->name);

    $response3 = $this->json('GET', 'api/stats/users-tags/' . $tag->id);
    $response3->assertStatus(200);

  }

  /** @test */
  public function get_users_individual_tag_returns_proper_json_response() {

    $this->createBaseTag();
    $this->createBaseGoalWithSubgoal();

    $this->goal->attachTagToGoal($this->tag->name);

    Goal::newGoal('Another Goal' , 1, 1, 1);

    $response = $this->json('GET', 'api/stats/users-tags/' . $this->tag->id);
    $response->assertJson([
      'tag_subgoals' => [

      ],
      'tag_subgoals_count' => 1,
      'tag_subgoals_cost' => 700,
      'tag_subgoals_days' => 10,
      'tag_subgoals_hours' => 100,

      'subgoals_count' => 2,
      'subgoals_cost' => 701,
      'subgoals_hours' => 101,
      'subgoals_days' => 11,

    ]);

  }

  /** @test */
  public function individual_goal_general_stats_can_be_viewed_by_anyone() {

    $this->createBaseGoal();
    $this->canBeViewedByAnyone('api/stats/individual-goal-general-stats/' . $this->goal->slug);

  }


  //StatsController Needs some serious refactoring and considering moving logic to a service provider
  //Keep in mind TDD while writing new methods on models

}
