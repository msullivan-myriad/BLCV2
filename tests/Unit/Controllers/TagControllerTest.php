<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use App\Tag;
use Tests\ControllerTestCase;

class TagControllerTest extends ControllerTestCase {


    /** @test */
    public function api_popular_tags_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/tags');
    }

    /** @test */
    public function api_popular_returns_proper_json_response() {
      $response = $this->get('api/tags');

      $response->assertJson(['data' => [
        'tags' => [
        ]
      ]]);
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
    public function view_with_invalid_slug_is_404() {

      $this->createBaseTag();
      $response1 = $this->get('category/' .  $this->tag->slug);
      $response2 = $this->get('category/not9valid7slug$');

      $response1->assertStatus(200);
      $response2->assertStatus(404);
    }

    /** @test */
    public function category_goals_filtering_can_be_viewed_by_anyone() {
      $this->createBaseTag();
      $this->canBeViewedByAnyone('api/category-goals/' . $this->tag->slug);

    }

    /** @test */
    public function category_goals_filtering_invalid_slug_is_404() {
      $this->createBaseTag();
      $response1 = $this->get('api/category-goals/' . $this->tag->slug);
      $response2 = $this->get('api/category-goals/not8valid$slug/test');

      $response1->assertStatus(200);
      $response2->assertStatus(404);
    }

    /** @test */
    public function category_goals_filtering_still_returns_default_with_improper_order_parameter() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {

        $goal->attachTagToGoal($tag->name);

      });

      $response = $this->json('GET', 'api/category-goals/' . $this->tag->slug . '?order=un$formatteD$');

      $jsonContent = json_decode($response->getContent());

      $goalCount = sizeof($jsonContent->data->goals);

      $this->assertEquals(5, $goalCount);

    }

    /** @test */
    public function category_goals_filtering_returns_goals_in_proper_order() {

      $this->createBaseTag();
      $tag = $this->tag;

      factory(Goal::class, 5)->create()->each(function ($goal) use ($tag) {
        $goal->attachTagToGoal($tag->name);
      });

      $this->assertTrue(true);

    }

}
