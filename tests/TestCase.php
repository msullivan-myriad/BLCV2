<?php

namespace Tests;

use App\Goal;
use App\Subgoal;
use App\User;
use App\Tag;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    use DatabaseTransactions;

    protected $goal;
    protected $tag;
    protected $user;
    protected $admin;
    protected $subgoal;

    protected function createBaseGoal() {
      $this->goal = factory(Goal::class, 'base-test-goal')->create();
    }

     protected function createBaseTag() {
      $this->tag = factory(Tag::class, 'base-test-tag')->create();
    }

    protected function createBaseUser() {
      $this->user = factory(User::class, 'base-test-user')->create();
    }

    protected function createBaseUserWithProfile() {
      $this->createBaseUser();
      $this->user->createProfile();
    }

    protected function createAdminUser() {
      $this->admin = factory(User::class, 'admin')->create();
    }

    protected function createBaseGoalWithSubgoal() {
      $this->createBaseGoal();
      $this->createBaseUser();
      $this->be($this->user);
      $this->goal->createDefaultSubgoal();
      $this->subgoal = Subgoal::where('goal_id', $this->goal->id)->first();
    }

}
