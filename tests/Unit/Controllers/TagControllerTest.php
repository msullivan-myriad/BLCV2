<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagControllerTest extends TestCase {

    use DatabaseTransactions;

    //Test api popular tags

    //Test api goals with tags

    //Need to move to parent controller test object
    private function canBeViewedByAnyone($url) {
        $response = $this->get($url);
        $response->assertStatus(200);
    }

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
      //Left off here
      $this->assertTrue(true);
    }

}
