<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use App\Tag;
use Tests\ControllerTestCase;

class TagControllerTest extends ControllerTestCase {


    /** @test */
    public function api_popular_tags_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/tags?count=5');
    }

    /** @test */
    public function api_popular_tags_can_return_specific_amount_of_tags_based_on_a_parameter() {

      factory(Tag::class, 10)->create();
      $response = $this->get('api/tags?count=5');

      $jsonContent = json_decode($response->getContent());
      $tags = $jsonContent->data->tags;

      $this->assertEquals(5, count($tags));
    }

    /** @test */
    public function api_popular_returns_proper_json_response() {
      $response = $this->get('api/tags?count=5');

      $response->assertJson(['data' => [
        'tags' => [
        ]
      ]]);

    }

    /** @test */
    public function api_popular_requires_count_to_be_given() {

      $response1 = $this->get('api/tags');
      $response2 = $this->get('api/tags?count=5');

      $response1->assertStatus(302);
      $response2->assertStatus(200);

    }


    /** @test */
    public function api_goals_with_tags_can_be_viewed_by_anyone() {
      $this->createBaseTag();
      $this->canBeViewedByAnyone('api/tags/' . $this->tag->id);
    }

    /** @test */
    public function api_goals_with_tags_returns_proper_json_response() {
      $this->createBaseTag();
      $this->createBaseGoal();

      $this->goal->attachTagToGoal($this->tag->name);

      $response = $this->get('api/tags/' . $this->tag->id);

      $response->assertJson([
        'current_page' => 1,
        'data' => [],
        'per_page' => 3,
        'total' => 1,
      ]);

    }

    /** @test */
    public function view_can_be_viewed_by_anyone() {
      $this->createBaseTag();
      $this->canBeViewedByAnyone('category/' . $this->tag->slug);
    }

    /** @test */
    public function view_with_slug_that_does_not_exist_is_403() {

      $this->createBaseTag();
      $response1 = $this->get('category/' .  $this->tag->slug);
      $response2 = $this->get('category/not9valid7slug$');

      $response1->assertStatus(200);
      $response2->assertStatus(403);
    }

    /** @test */
    public function category_goals_filtering_can_be_viewed_by_anyone() {
      $this->createBaseTag();
      $this->canBeViewedByAnyone('api/category-goals/' . $this->tag->slug, ['order' => 'cost-desc']);

    }

    /** @test */
    public function category_goals_filtering_invalid_slug_is_404() {
      $this->createBaseTag();
      $response1 = $this->json('GET', 'api/category-goals/' . $this->tag->slug, ['order' => 'cost-desc']);
      $response2 = $this->json('GET', 'api/category-goals/not8valid$slug/test', ['order' => 'cost-desc']);

      $response1->assertStatus(200);
      $response2->assertStatus(404);
    }

    /** @test */
    public function category_goals_filtering_only_accepts_specific_order_options() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 1)->create()->each(function ($goal) use ($tag) {

        $goal->attachTagToGoal($tag->name);

      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug, ['order' => 'not-real'] );

      $response->assertStatus(422);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_cost_desc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=cost-desc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertGreaterThanOrEqual($goals[1]->cost, $goals[0]->cost);
      $this->assertGreaterThanOrEqual($goals[2]->cost, $goals[1]->cost);
      $this->assertGreaterThanOrEqual($goals[3]->cost, $goals[2]->cost);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_cost_asc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=cost-asc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertLessThanOrEqual($goals[1]->cost, $goals[0]->cost);
      $this->assertLessThanOrEqual($goals[2]->cost, $goals[1]->cost);
      $this->assertLessThanOrEqual($goals[3]->cost, $goals[2]->cost);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_hours_asc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=hours-asc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertLessThanOrEqual($goals[1]->hours, $goals[0]->hours);
      $this->assertLessThanOrEqual($goals[2]->hours, $goals[1]->hours);
      $this->assertLessThanOrEqual($goals[3]->hours, $goals[2]->hours);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_hours_desc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=hours-desc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertGreaterThanOrEqual($goals[1]->hours, $goals[0]->hours);
      $this->assertGreaterThanOrEqual($goals[2]->hours, $goals[1]->hours);
      $this->assertGreaterThanOrEqual($goals[3]->hours, $goals[2]->hours);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_days_asc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=days-asc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertLessThanOrEqual($goals[1]->days, $goals[0]->days);
      $this->assertLessThanOrEqual($goals[2]->days, $goals[1]->days);
      $this->assertLessThanOrEqual($goals[3]->days, $goals[2]->days);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_days_desc() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=days-desc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertGreaterThanOrEqual($goals[1]->days, $goals[0]->days);
      $this->assertGreaterThanOrEqual($goals[2]->days, $goals[1]->days);
      $this->assertGreaterThanOrEqual($goals[3]->days, $goals[2]->days);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_popular_asc() {

      $this->createBaseTag();
      $tag = $this->tag;

      $this->createBaseUser();
      $this->be($this->user);

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);

        if (rand(0,1)) {
          $goal->createDefaultSubgoal();
        }

      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=popular-asc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertLessThanOrEqual($goals[1]->subgoals_count, $goals[0]->subgoals_count);
      $this->assertLessThanOrEqual($goals[2]->subgoals_count, $goals[1]->subgoals_count);
      $this->assertLessThanOrEqual($goals[3]->subgoals_count, $goals[2]->subgoals_count);
      $this->assertLessThanOrEqual($goals[4]->subgoals_count, $goals[3]->subgoals_count);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_popular_desc() {

      $this->createBaseTag();
      $tag = $this->tag;

      $this->createBaseUser();
      $this->be($this->user);

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);

        if (rand(0,1)) {
          $goal->createDefaultSubgoal();
        }

      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=popular-desc');
      $jsonContent = json_decode($response->getContent());
      $goals = $jsonContent->data->goals;

      $this->assertGreaterThanOrEqual($goals[1]->subgoals_count, $goals[0]->subgoals_count);
      $this->assertGreaterThanOrEqual($goals[2]->subgoals_count, $goals[1]->subgoals_count);
      $this->assertGreaterThanOrEqual($goals[3]->subgoals_count, $goals[2]->subgoals_count);
      $this->assertGreaterThanOrEqual($goals[4]->subgoals_count, $goals[3]->subgoals_count);

    }

    /** @test */
    public function api_tag_search_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/tags/search?term=test');
    }

    /** @test  */
    public function api_tag_search_requires_a_search_term() {

    }

    /** @test */
    public function api_tag_search_returns_expected_json_response() {

    }


}
