<?php

use App\Experience;
use Illuminate\Database\Seeder;
use App\Goal;
use App\User;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {

        $tags = factory(App\Tag::class, 50)->create();

        $goals = factory(App\Goal::class, 1000)->create()->each(function ($goal) use ($tags) {

          $tag = $tags[rand(0,49)];
          $goal->attachTagToGoal($tag->name);

          $secondLevelTag = $tags[rand(0,49)];

          if ($secondLevelTag->name != $tag->name) {
            $goal->attachTagToGoal($secondLevelTag->name);
          }

        });

        //Create 100 users
        factory(App\User::class, 400)->create()->each(function ($user) use ($goals) {

          $user->createProfile();

          Auth::login($user);

          //Create random subgoals for goals
          $goals[rand(0, 99)]->createNewSubgoalWithRandomValues();
          $goals[rand(100, 199)]->createNewSubgoalWithRandomValues();
          $goals[rand(200, 299)]->createNewSubgoalWithRandomValues();
          $goals[rand(300, 399)]->createNewSubgoalWithRandomValues();
          $goals[rand(400, 499)]->createNewSubgoalWithRandomValues();
          $goals[rand(500, 599)]->createNewSubgoalWithRandomValues();
          $goals[rand(600, 699)]->createNewSubgoalWithRandomValues();
          $goals[rand(700, 799)]->createNewSubgoalWithRandomValues();
          $goals[rand(800, 899)]->createNewSubgoalWithRandomValues();
          $goals[rand(900, 999)]->createNewSubgoalWithRandomValues();


          //Create four experiences for each user
          $experience1 = factory(App\Experience::class)->make();
          $experience1->user()->associate($user->id);
          $experience1->goal()->associate($goals[rand(0,249)]);
          $experience1->save();

          $experience2 = factory(App\Experience::class)->make();
          $experience2->user()->associate($user->id);
          $experience2->goal()->associate($goals[rand(250,499)]);
          $experience2->save();

          $experience3 = factory(App\Experience::class)->make();
          $experience3->user()->associate($user->id);
          $experience3->goal()->associate($goals[rand(500,749)]);
          $experience3->save();

          $experience4 = factory(App\Experience::class)->make();
          $experience4->user()->associate($user->id);
          $experience4->goal()->associate($goals[rand(750,999)]);
          $experience4->save();


          //Vote on 20 random experiences for each user
          for ($x = 0; $x < 20; $x++) {

            $randExperience = Experience::inRandomOrder()->first();

            if ($randExperience != null && $randExperience->user_id != $user->id) {
              $vote = factory(App\Vote::class)->make();
              $vote->experience()->associate($randExperience);
              $vote->user()->associate($user);
              $vote->save();
            }

          }

          Auth::logout();

        });

        //Get all goals as collection, then loop through and update the goal averages
        $all = Goal::all();

        $all->each(function($g) {
            $g->updateGoalAverages();
        });

        $mike = factory(App\User::class, 'mike')->create();
        $mike->createProfile();

    }
}
