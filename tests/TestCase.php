<?php

namespace Tests;

use App\Experience;
use App\Goal;
use App\Subgoal;
use App\User;
use App\Tag;
use App\Vote;
use function factory;
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
    protected $experience;
    protected $alternateUser;

    protected function createBaseGoal() {
      $this->goal = factory(Goal::class, 'base-test-goal')->create();
    }

     protected function createBaseTag() {
      $this->tag = factory(Tag::class, 'base-test-tag')->create();
    }

    protected function createBaseUser() {
      $this->user = factory(User::class, 'base-test-user')->create();
    }

    protected function createAlternateUser() {
      $this->alternateUser = factory(User::class, 'alternate-test-user')->create();
    }

    protected function createBaseExperience() {
      $this->experience = factory(Experience::class, 'base-test-experience')->create();
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

    protected function createBaseGoalAndUserWithExperience() {
      $this->experience = factory(Experience::class, 'base-test-experience')->make();
      $this->createBaseGoal();
      $this->createBaseUser();
      $this->experience->user()->associate($this->user);
      $this->experience->goal()->associate($this->goal);
      $this->experience->save();
    }

    protected function createBaseGoalAndUserWithExperienceAndVote() {

      $this->experience = factory(Experience::class, 'base-test-experience')->make();
      $this->createBaseGoal();
      $this->createBaseUser();
      $this->experience->user()->associate($this->user);
      $this->experience->goal()->associate($this->goal);
      $this->experience->save();

      $vote = new Vote();
      $vote->vote = 1;
      $vote->experience()->associate($this->experience);
      $vote->user()->associate($this->user);
      $vote->save();

    }



}
