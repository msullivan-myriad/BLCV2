<?php

namespace Tests\Unit;

use App\User;
use App\Goal;
use App\Subgoal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalTest extends TestCase {

    use DatabaseTransactions;


    private $goal;
    private $user;

  //Goal should be able to have a static method to created rather than have to require that it is called from the user object
    private function createBaseGoal() {
      $this->goal = new Goal;

      $this->goal->name = 'Test Goal Name';
      $this->goal->slug = 'test-goal-name';
      $this->goal->cost = 700;
      $this->goal->days = 10;
      $this->goal->hours= 100;
      $this->goal->subgoals_count = 0;
      $this->goal->save();

    }

    private function createBaseGoalWithSubgoal() {

      $this->createBaseGoal();
      $this->createBaseUser();
      $this->be($this->user);
      $this->goal->createDefaultSubgoal();

    }

    private function createBaseUser() {

      $this->user = User::create([
          'name' => 'Jonathan',
          'email' => 'jonathan@email.com',
          'password' => bcrypt('password'),
          'admin' => false,
      ]);

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
    public function goal_can_create_default_subgoal_using_user_as_argument() {

      $this->createBaseUser();
      $this->createBaseGoal();
      $this->goal->createDefaultSubgoal($this->user);

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


      //Condense the default create goal and subgoal and assert they work
    }

}
