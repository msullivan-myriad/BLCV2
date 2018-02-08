<?php

namespace Tests;

use App\Goal;
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

    protected function createBaseGoal() {
      $this->goal = factory(Goal::class, 'base-test-goal')->create();
    }

     protected function createBaseTag() {
      $this->tag = factory(Tag::class, 'base-test-tag')->create();
    }

    protected function createBaseUser() {
      $this->user = factory(User::class, 'base-test-user')->create();
    }

    protected function createBaseGoalWithSubgoal() {
      $this->createBaseGoal();
      $this->createBaseUser();
      $this->be($this->user);
      $this->goal->createDefaultSubgoal();
    }




}
