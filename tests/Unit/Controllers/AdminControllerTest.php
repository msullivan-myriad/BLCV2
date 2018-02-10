<?php

namespace Tests\Unit;

use App\Goal;
use Tests\ControllerTestCase;

class AdminControllerTest extends ControllerTestCase {


  /** @test */
  public function api_individual_tag_requires_admin() {

    $this->createBaseTag();
    $this->canOnlyBeViewedBy('admin', 'GET', 'api/admin/api-tags/' . $this->tag->id);

  }

  /** @test */
  public function api_individual_tag_returns_proper_json_response() {

    $this->createBaseTag();
    $this->createAdminUser();
    $this->be($this->admin);

    $tag = $this->tag;

    factory(Goal::class, 2)->create()->each(function($goal) use ($tag) {
     $goal->attachTagToGoal($tag->name);
    });

    $response = $this->json('GET', 'api/admin/api-tags/' . $this->tag->id);

    $response->assertJson([
      'data' => [
        'goals' => [
          [ 'tags' => [] ]
        ],
        'tag' => [
          'count' => 2,
          'id' => $this->tag->id,
        ]
      ],
    ]);

  }

}
