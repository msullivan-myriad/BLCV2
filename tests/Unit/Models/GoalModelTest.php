<?php

namespace Tests\Unit;

use App\User;
use App\Goal;
use App\Tag;
use App\Subgoal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

class GoalModelTest extends TestCase {

    use DatabaseTransactions;

    private $goal;
    private $user;

    private function createBaseGoal() {

      $this->goal = factory(Goal::class, 'base-test-goal')->create();

    }

    private function createBaseGoalWithSubgoal() {

      $this->createBaseGoal();
      $this->createBaseUser();
      $this->be($this->user);
      $this->goal->createDefaultSubgoal();

    }

    private function createBaseGoalWithMultipleSubgoals($count) {

      $this->createBaseGoal();
      $goal = $this->goal;

      factory(User::class, $count)->create()->each(function($user) use ($goal) {

          Auth::login($user);

          $goal->createNewSubgoalWithRandomValues();

          Auth::logout();

      });


    }

    private function createBaseUser() {

      $this->user = User::create([
          'name' => 'Jonathan',
          'email' => 'jonathan@email.com',
          'password' => bcrypt('password'),
          'admin' => false,
      ]);

    }

    private function createBaseTag() {

      $this->tag = factory(Tag::class, 'base-test-tag')->create();

    }

    /** @test */
    public function goal_can_create_default_subgoal() {


      $this->createBaseGoalWithSubgoal();

      $subgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();


      $this->assertNotNull($subgoal);

    }

    /** @test */
    public function goal_and_its_subgoals_can_be_deleted() {

      $this->createBaseGoalWithSubgoal();

      $goal = Goal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $subgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $this->assertNotNull($goal);
      $this->assertNotNull($subgoal);

      $this->goal->deleteGoal();

      $goalAfterDeleted = Goal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $subgoalAfterDeleted = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $this->assertNull($goalAfterDeleted);
      $this->assertNull($subgoalAfterDeleted);

    }

    /** @test */
    public function goal_and_subgoals_title_and_slug_can_be_edited() {

      $this->createBaseGoalWithSubgoal();

      $goal = Goal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $subgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $this->assertNotNull($goal);
      $this->assertNotNull($subgoal);

      $this->goal->editGoal('New Test Goal Name');

      $goalAfterEdit = Goal::where([
        'name' => 'New Test Goal Name',
        'slug' => 'new-test-goal-name',
      ])->first();

      $subgoalAfterEdit = Subgoal::where([
        'name' => 'New Test Goal Name',
        'slug' => 'new-test-goal-name',
      ])->first();


      $this->assertNotNull($goalAfterEdit);
      $this->assertNotNull($subgoalAfterEdit);

      $searchDefaultGoal = Goal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $searchDefaultSubgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $this->assertNull($searchDefaultGoal);
      $this->assertNull($searchDefaultSubgoal);

    }


    /** @test */
    public function goal_can_create_subgoal_with_different_numbers() {

      $this->createBaseGoal();

      $goal = Goal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
        'cost' => 700,
        'days' => 10,
        'hours' => 100,
      ])->first();

      $this->assertNotNull($goal);

      $this->createBaseUser();
      $this->be($this->user);
      $this->goal->createNewSubgoal(701, 4, 203);

      $subgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
        'cost' => 701,
        'hours' => 4,
        'days' => 203,
      ])->first();

      $this->assertNotNull($subgoal);

    }

    /** @test */
    public function goal_averages_can_be_updated() {

      $this->createBaseGoal();
      $this->createBaseUser();

      $subgoal1 = new Subgoal();
      $subgoal1->user_id = $this->user->id;
      $subgoal1->goal_id = $this->goal->id;
      $subgoal1->name = 'Test Goal Name';
      $subgoal1->slug = 'test-goal-name';
      $subgoal1->cost = 0;
      $subgoal1->days = 1;
      $subgoal1->hours = 30;
      $subgoal1->save();

      $subgoal2 = new Subgoal();
      $subgoal2->user_id = $this->user->id;
      $subgoal2->goal_id = $this->goal->id;
      $subgoal2->name = 'Test Goal Name';
      $subgoal2->slug = 'test-goal-name';
      $subgoal2->cost = 10;
      $subgoal2->days = 3;
      $subgoal2->hours = 20;
      $subgoal2->save();

      $this->goal->updateGoalAverages();

      $goal = Goal::find($this->goal->id);

      $this->assertEquals(5, $goal->cost);
      $this->assertEquals(2, $goal->days);
      $this->assertEquals(25, $goal->hours);


    }


    /** @test */
    public function updating_goal_averages_will_delete_goal_if_it_has_no_subgoals() {

      $this->createBaseGoal();
      $this->createBaseUser();
      $goalId = $this->goal->id;

      $goal = Goal::find($goalId);;

      $this->assertNotNull($goal);

      $this->goal->updateGoalAverages();

      $searchForGoalAfterUpdate = Goal::find($goalId);

      $this->assertNull($searchForGoalAfterUpdate);

    }

    /** @test */
    public function first_letter_of_each_word_in_goal_name_will_be_capitalized() {

      $this->goal = new Goal;
      $this->goal->name = 'checK the GOALS capiTALization';
      $this->goal->slug = 'check-the-goals-capitalization';
      $this->goal->cost = 700;
      $this->goal->days = 10;
      $this->goal->hours= 100;
      $this->goal->subgoals_count = 0;
      $this->goal->save();

      $this->assertEquals('Check The Goals Capitalization', $this->goal->name);

    }


    /** @test */
    public function can_create_goal_with_static_method() {

      $this->createBaseUser();
      $this->be($this->user);

      Goal::newGoal('Testing static method', 270, 11, 1);

      $findGoal = Subgoal::where([
        'name' => 'Testing Static Method',
        'slug' => 'testing-static-method',
        'cost' => 270,
        'hours' => 11,
        'days' => 1,
      ])->first();

      $findSubgoal = Subgoal::where([
        'name' => 'Testing Static Method',
        'slug' => 'testing-static-method',
        'cost' => 270,
        'hours' => 11,
        'days' => 1,
      ])->first();

      $this->assertNotNull($findGoal);
      $this->assertNotNull($findSubgoal);

    }


    /** @test */
    public function goal_can_create_subgoal_with_random_values() {

      $this->createBaseUser();
      $this->createBaseGoal();
      $this->be($this->user);

      $this->goal->createNewSubgoalWithRandomValues();


      $findSubgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-name',
      ])->first();

      $this->assertNotNull($findSubgoal);

    }

    /** @test  */
    public function can_attach_tag_that_has_not_been_created_to_goal() {

      $this->createBaseGoal();

      $this->goal->attachTagToGoal('New Test Tag');

      $this->assertDatabaseHas('goal_tag', [
        'goal_id' => $this->goal->id,
      ]);

      $findTag = Tag::where('name', 'New Test Tag')->first();

      $this->assertNotNull($findTag);

    }

    /** @test */
    public function can_attach_existing_tag_to_goal() {

      $this->createBaseGoal();
      $this->createBaseTag();

      $this->goal->attachTagToGoal($this->tag->name);


      $this->assertDatabaseHas('goal_tag', [
        'goal_id' => $this->goal->id,
        'tag_id' => $this->tag->id,
      ]);

    }

    /** @test */
    public function can_remove_a_tag_from_a_goal() {

      $this->createBaseGoal();
      $this->createBaseTag();

      $this->goal->attachTagToGoal($this->tag->name);

      $this->assertDatabaseHas('goal_tag', [
        'goal_id' => $this->goal->id,
        'tag_id' => $this->tag->id,
      ]);

      $this->goal->removeTagFromGoal($this->tag->id);

      $this->assertDatabaseMissing('goal_tag', [
        'goal_id' => $this->goal->id,
        'tag_id' => $this->tag->id,
      ]);

    }

    /** @test */
    public function can_return_all_goals() {

      factory(Goal::class, 12)->create();

      $findAllGoals = Goal::allGoals()->get();

      $this->assertEquals(12, count($findAllGoals));

    }

    /** @test */
    public function can_return_all_goals_with_specific_tag() {

      $this->createBaseTag();

      factory(Goal::class, 6)->create()->each(function($goal) {
          $goal->attachTagToGoal($this->tag->name);
      });

      factory(Goal::class, 10)->create();

      $findAllGoals = Goal::allGoals()->get();
      $findGoalsWithTag = Goal::goalsWithSpecificTag($this->tag->id)->get();

      $this->assertEquals(16, count($findAllGoals));
      $this->assertEquals(6, count($findGoalsWithTag));

    }

    /** @test */
    public function can_return_all_goals_with_associated_tags() {

        $this->createBaseTag();

        $moreTags = factory(Tag::class, 2)->create();

        $tag1 = $moreTags[0];
        $tag2 = $moreTags[1];

        $goals = factory(Goal::class, 10)->create()->each(function($goal) use ($tag1, $tag2) {

          $goal->attachTagToGoal($tag1->name);
          $goal->attachTagToGoal($tag2->name);

        });

        $findGoalsWithTags = Goal::allGoalsWithTags()->get();

        foreach ($findGoalsWithTags as $goal) {
          $this->assertEquals(2, count($goal->tags));
        }

    }

}
