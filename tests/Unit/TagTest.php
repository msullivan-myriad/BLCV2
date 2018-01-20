<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagTest extends TestCase {

    use DatabaseTransactions;

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

}
