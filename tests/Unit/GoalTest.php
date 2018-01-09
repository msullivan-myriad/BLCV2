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

  //Goal should be able to have a static method to created rather than have to require that it is called from the user object
    private function createBaseGoal() {
      $this->goal = new Goal;

      $this->goal->name = 'Test Goal Name';
      $this->goal->slug = 'test-goal-slug';
      $this->goal->cost = 700;
      $this->goal->days = 10;
      $this->goal->hours= 100;
      $this->goal->subgoals_count = 0;
      $this->goal->save();

    }

    /** @test */
    public function goal_can_create_default_subgoal() {

      $user = User::create([
          'name' => 'Jonathan',
          'email' => 'jonathan@email.com',
          'password' => bcrypt('password'),
          'admin' => false,
      ]);

      $this->be($user);

      $this->createBaseGoal();

      $this->goal->createDefaultSubgoal();

      $subgoal = Subgoal::where([
        'name' => 'Test Goal Name',
        'slug' => 'test-goal-slug',
      ])->first();


      $this->assertNotNull($subgoal);

    }

}
