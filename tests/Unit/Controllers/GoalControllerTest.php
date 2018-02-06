<?php

namespace Tests\Unit;

use App\Goal;
use App\User;
use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalControllerTest extends TestCase {

    use DatabaseTransactions;

    private $testGoal;

    //Need to move to parent controller test object
    private function canBeViewedByAnyone($url) {
        $response = $this->get($url);
        $response->assertStatus(200);
    }

    private function canOnlyBeViewedBy($userType, $postType, $url, $array = false) {

      //Going to be useful across pretty much all controllers
      //Maybe make this a trait?

      if($userType == 'admin') {
        $user = factory(User::class, 'admin')->create();

      }
      else if ($userType == 'auth') {
        $user = factory(User::class, 'base-test-user')->create();
      }


      if ($postType == 'GET') {

      }

      else if ($postType == 'POST') {

        if ($array) {
          $request = $this->post($url, $array);
          $secondRequest = $this->actingAs($user)->post($url, $array);
        }
        else {
          $request = $this->post($url);
          $secondRequest = $this->actingAs($user)->post($url);
        }
      }

      else if ($postType == 'DELETE') {

        if ($array) {
          $request = $this->delete($url, $array);
          $secondRequest = $this->actingAs($user)->delete($url, $array);
        }
        else {
          $request = $this->delete($url);
          $secondRequest = $this->actingAs($user)->delete($url);
        }
      }

      else {
        $this->assertTrue(false);
      }

      $request->assertStatus(302);
      $secondRequest->assertStatus(200);

    }

    private function createTestGoal() {
      $this->testGoal = factory(Goal::class, 'base-test-goal')->create();
    }

    /** @test */
    public function index_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('goals');
    }

    /** @test */
    public function individual_goal_can_be_viewed_by_anyone() {
      factory(Goal::class, 'base-test-goal')->create();
      $this->canBeViewedByAnyone('goal/test-goal-name');
    }

    /** @test */
    public function api_index_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/goals');
    }

    /** @test */
    public function api_index_returns_all_goals() {

      factory(Goal::class, 5)->create();

      $response = $this->get('api/goals');
      $jsonAsArray = json_decode($response->getContent());
      $jsonGoalsCount = sizeof($jsonAsArray->data->all_goals);
      $this->assertEquals(5, $jsonGoalsCount);
    }

    /** @test */
    public function api_popular_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/popular');

    }

    /** @test */
    public function api_popular_is_paginated() {

      factory(Goal::class, 21)->create();

      $response = $this->get('api/popular');
      $jsonAsArray = json_decode($response->getContent());
      $popularGoals = $jsonAsArray->data->popular_goals;

      $this->assertEquals(1, $popularGoals->current_page);
      $this->assertEquals(10, $popularGoals->per_page);
      $this->assertEquals(21, $popularGoals->total);
    }

    /** @test */
    public function api_search_can_be_viewed_by_anyone() {
      $this->canBeViewedByAnyone('api/search');
    }

    /** @test */
    public function api_search_can_search_for_goals() {

      factory(Goal::class, 5)->create();
      $this->createTestGoal();

      $request = $this->get('api/search?search=Test Goal Name');
      $jsonAsArray = json_decode($request->getContent());

      $this->assertEquals($this->testGoal->id, $jsonAsArray[0]->id);
    }

    /** @test */
    public function api_tag_requires_admin_user() {

      $this->createTestGoal();

      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';

      $this->canOnlyBeViewedBy('admin', 'POST', $url, ['tag_name' => 'filler']);

    }

    /** @test */
    public function api_tag_validates_tag_names() {

      $this->createTestGoal();
      $user = factory(User::class, 'admin')->create();
      $this->be($user);
      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';

      $request = $this->post($url);
      $request->assertStatus(302);

      $request1 = $this->post($url, ['tag_name' => 1]);
      $request1->assertStatus(302);

      $request2 = $this->post($url, ['tag_name' => 'tw']);
      $request2->assertStatus(302);

      $request3 = $this->post($url, ['tag_name' => 'Really really long string that is over fifty characters']);
      $request3->assertStatus(302);

      $request4 = $this->post($url, ['tag_name' => 'Normal Name']);
      $request4->assertStatus(200);

    }

    /** @test */
    public function api_tag_returns_proper_json_response() {

      $this->createTestGoal();
      $user = factory(User::class, 'admin')->create();
      $this->be($user);
      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';
      $response = $this->post($url, ['tag_name' => 'Normal Name']);

      $jsonAsArray = json_decode($response->getContent());

      $this->assertTrue($jsonAsArray->data->success);
      $this->assertInternalType("int", $jsonAsArray->data->tag_id);


    }

    /** @test */
    public function api_tag_requires_a_goal() {

      $user = factory(User::class, 'admin')->create();
      $this->be($user);
      $url = 'api/admin/goals/1/tag';
      $response = $this->post($url, ['tag_name' => 'Normal Name']);
      $response->assertStatus(404);

    }

    /** @test */
    public function api_remove_tag_requires_admin_user() {

      $this->createTestGoal();
      $tag = factory(Tag::class, 'base-test-tag')->create();

      $this->testGoal->attachTagToGoal('Test Tag');

      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';

      $this->canOnlyBeViewedBy('admin', 'DELETE', $url, ['tag_id' => $tag->id]);

    }

    /** @test */
    public function api_remove_tag_returns_proper_json_response() {

      $this->createTestGoal();
      $tag = factory(Tag::class, 'base-test-tag')->create();

      $this->testGoal->attachTagToGoal('Test Tag');

      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';
      $user = factory(User::class, 'admin')->create();

      $response = $this->actingAs($user)->delete($url, ['tag_id' => $tag->id]);
      $response->assertStatus(200);

      $jsonAsArray = json_decode($response->getContent());
      $this->assertTrue($jsonAsArray->data->success);

    }

    /** @test */
    public function api_remove_tag_validates_tag_id() {

      $this->createTestGoal();
      $tag = factory(Tag::class, 'base-test-tag')->create();

      $this->testGoal->attachTagToGoal('Test Tag');

      $url = 'api/admin/goals/' . $this->testGoal->id . '/tag';
      $user = factory(User::class, 'admin')->create();

      $this->be($user);

      $response1 = $this->delete($url, ['tag_id' => '']);
      $response1->assertStatus(302);

      $response2 = $this->delete($url, ['tag_id' => 'string']);
      $response2->assertStatus(302);

      $response3 = $this->delete($url, ['tag_id' => $tag->id]);
      $response3->assertStatus(200);

    }

    /** @test */
    public function api_delete_requires_admin_user() {

      $this->createTestGoal();

      $this->canOnlyBeViewedBy('admin', 'DELETE', 'api/admin/goals/' . $this->testGoal->id);

    }

    /** @test */
    public function api_delete_returns_proper_json_response() {

      $this->createTestGoal();
      $user = factory(User::class, 'admin')->create();

      $response = $this->actingAs($user)->delete('api/admin/goals/' . $this->testGoal->id);

      $jsonAsArray = json_decode($response->getContent());

      $this->assertTrue($jsonAsArray->data->success);

    }

    /** @test */
    public function api_edit_title_requires_admin_user() {

      $this->createTestGoal();

      $url = 'api/admin/goals/' . $this->testGoal->id . '/edit';

      $this->canOnlyBeViewedBy('admin', 'POST', $url, ['newTitle' => 'something']);

    }

    /** @test */
    public function api_edit_title_has_validation_on_title() {

      $this->createTestGoal();

      $user = factory(User::class, 'admin')->create();
      $this->be($user);

      $url = 'api/admin/goals/' . $this->testGoal->id . '/edit';

      $response1 = $this->post($url);
      $response1->assertStatus(302);

      $response2 = $this->post($url, ['newTitle' => '']);
      $response2->assertStatus(302);

      $response3 = $this->post($url, ['newTitle' => 88]);
      $response3->assertStatus(302);

      $response4 = $this->post($url, ['newTitle' => 'Filler Title']);
      $response4->assertStatus(200);

    }

    /** @test */
    public function api_edit_title_returns_proper_json_response() {

      $this->createTestGoal();
      $user = factory(User::class, 'admin')->create();
      $this->be($user);

      $url = 'api/admin/goals/' . $this->testGoal->id . '/edit';

      $response = $this->post($url, ['newTitle' => 'Filler Title']);

      $jsonAsArray = json_decode($response->getContent());

      $this->assertTrue($jsonAsArray->data->success);


    }

    /** @test */
    public function api_create_requires_authenticated_user() {

      $url = 'api/goals/create';

      $this->canOnlyBeViewedBy('auth', 'POST', $url, [
        'title' => 'something',
        'cost' => 89,
        'days' => 10,
        'hours' => 2,
      ]);

    }

    /** @test */
    public function api_create_has_proper_validation() {

      $user = factory(User::class, 'admin')->create();
      $this->be($user);

      $response1 = $this->post('api/goals/create', [
        'title' => 'Something',
        'cost' => 10,
        'days' => 10,
        'hours' => 10,
      ]);

      $response2 = $this->post('api/goals/create', [
        'title' => 'Something',
        'cost' => 10,
        'days' => 10,
        'hours' => 10,
      ]);

      $response1->assertStatus(200);
      $response2->assertStatus(302);

    }

    /** @test */
    public function api_create_returns_proper_json_response() {


      $user = factory(User::class, 'admin')->create();
      $this->be($user);

      $response = $this->post('api/goals/create', [
        'title' => 'Something',
        'cost' => 10,
        'days' => 10,
        'hours' => 10,
      ]);


      $jsonAsArray = json_decode($response->getContent());

      $this->assertTrue($jsonAsArray->data->success);


    }


    /** @test */
    public function api_new_requires_authenticated_user() {

      $url = 'api/goals';
      $this->createTestGoal();

      $this->canOnlyBeViewedBy('auth', 'POST', $url, [
        'cost' => 89,
        'days' => 10,
        'hours' => 2,
        'goal_id' => $this->testGoal->id,
      ]);

    }

    /** @test */
    public function api_new_has_proper_validation() {

      $user = factory(User::class, 'base-test-user')->create();
      $this->be($user);

      $this->createTestGoal();

      $response1 = $this->post('api/goals', [
        'cost' => 10,
        'days' => 10,
        'hours' => 10,
        'goal_id' => $this->testGoal->id,
      ]);

      $response1->assertStatus(200);

      $response2 = $this->post('api/goals', [
        'cost' => 8,
        'days' => 1,
        'hours' => 134,
        'goal_id' => $this->testGoal->id,
      ]);

      $response2->assertStatus(302);

    }

    /** @test */
    public function api_new_returns_proper_json_response() {

      $user = factory(User::class, 'base-test-user')->create();
      $this->be($user);

      $this->createTestGoal();

      $response = $this->post('api/goals', [
        'cost' => 10,
        'days' => 10,
        'hours' => 10,
        'goal_id' => $this->testGoal->id,
      ]);

      $jsonAsArray = json_decode($response->getContent());

      $this->assertTrue($jsonAsArray->data->success);


    }

}
