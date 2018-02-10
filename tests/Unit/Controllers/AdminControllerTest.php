<?php

namespace Tests\Unit;

use App\Goal;
use App\Tag;
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

  /** @test */
  public function api_tags_requires_admin() {

    $this->canOnlyBeViewedBy('admin', 'GET', 'api/admin/api-tags/');

  }

  /** @test */
  public function api_tags_returns_proper_json_response() {


    $this->createAdminUser();
    $this->be($this->admin);


    $tag1 = factory(Tag::class)->create();
    $tag2 = factory(Tag::class)->create();

    factory(Goal::class, 2)->create()->each(function($goal) use ($tag1, $tag2) {
      $goal->attachTagToGoal($tag1->name);
      $goal->attachTagToGoal($tag2->name);
    });

    factory(Goal::class, 2)->create()->each(function($goal) use ($tag1, $tag2) {
      $goal->attachTagToGoal($tag1->name);
    });

    factory(Goal::class, 2)->create()->each(function($goal) use ($tag1, $tag2) {
      $goal->attachTagToGoal($tag2->name);
    });



    $response = $this->json('GET', 'api/admin/api-tags');

    $jsonResponse = json_decode($response->getContent());

    $goals = $jsonResponse->data->goals;
    $tags = $jsonResponse->data->tags;

    $this->assertEquals(2, count($tags));
    $this->assertEquals(6, count($goals));


    $response->assertJson([
      'data' => [
        'goals' => [
          [
           'tags' => [
              ['id' => $tag1->id],
              ['id' => $tag2->id],
           ]
          ]
        ],

        'tags' => [
          ['id' => $tag1->id],
          ['id' => $tag2->id],
        ],

      ]
    ]);

  }

}
