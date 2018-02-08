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
      $tag = factory(Tag::class, 'base-test-tag')->create();
      $this->canBeViewedByAnyone('api/tags/' . $tag->id);
    }

    /** @test */
    public function api_goals_with_tags_returns_proper_json_response() {
      $tag = factory(Tag::class, 'base-test-tag')->create();
      $goal = factory(Goal::class, 'base-test-goal')->create();
      $goal->attachTagToGoal($tag->name);

      $response = $this->get('api/tags/' . $tag->id);

      $response->assertJson([
        'current_page' => 1,
        'data' => [],
        'per_page' => 3,
        'total' => 1,
      ]);

    }

}
