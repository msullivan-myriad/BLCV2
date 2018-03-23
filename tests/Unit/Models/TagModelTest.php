<?php

namespace Tests\Unit;

use App\Goal;
use Tests\TestCase;
use App\Tag;

class TagModelTest extends TestCase {


    /** @test */
    public function tag_can_be_created() {

      factory(Tag::class, 'base-test-tag')->create();

      $searchForTag = Tag::where([
        'name' => 'Test Tag',
      ])->first();

      $this->assertNotNull($searchForTag);

    }

    /** @test */
    public function tag_name_and_slug_will_be_formatted() {

      $tag = new Tag;
      $tag->name = 'TeSt TAG nAME';
      $tag->slug = str_slug($tag->name, "-");
      $tag->save();

      $searchForTag = Tag::where([
        'name' => 'Test Tag Name',
        'slug' => 'test-tag-name',
      ])->first();

      $this->assertNotNull($searchForTag);

    }

    /** @test */

    public function can_return_most_popular_tags_staticaly() {

      $tags = factory(Tag::class, 3)->create();
      $goals = factory(Goal::class, 3)->create();

      $currentGoalCount = 0;

      foreach($goals as $goal) {
        $currentGoalCount++;

        switch ($currentGoalCount) {

          case 1:
            $goal->attachTagToGoal($tags[0]);
            $goal->attachTagToGoal($tags[1]);
            $goal->attachTagToGoal($tags[2]);
            break;
          case 2:
            $goal->attachTagToGoal($tags[0]);
            $goal->attachTagToGoal($tags[1]);
            break;
          case 3:
            $goal->attachTagToGoal($tags[0]);
            break;
        }

      }

      $mostPopularTags = Tag::mostPopularTags()->get();

      $this->assertEquals(3, $mostPopularTags[0]->count);
      $this->assertEquals(2, $mostPopularTags[1]->count);
      $this->assertEquals(1, $mostPopularTags[2]->count);

    }

}
