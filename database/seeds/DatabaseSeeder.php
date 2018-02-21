<?php

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

        $tags = factory(App\Tag::class, 100)->create();

        $goals = factory(App\Goal::class, 100)->create()->each(function ($goal) use ($tags) {


          if (rand(0,2)) {
            $tag = $tags[rand(0,99)];
            $goal->attachTagToGoal($tag->name);

            if (rand(0,1)) {
              $secondLevelTag = $tags[rand(0,99)];

              if ($secondLevelTag->name != $tag->name) {
                $goal->attachTagToGoal($secondLevelTag->name);
              }
            }
          }

        });

        //Create 100 users
        factory(App\User::class, 100)->create()->each(function ($user) use ($goals) {

          $user->createProfile();

          Auth::login($user);

          $goals[rand(0, 33)]->createNewSubgoalWithRandomValues();
          $goals[rand(34, 66)]->createNewSubgoalWithRandomValues();
          $goals[rand(67, 99)]->createNewSubgoalWithRandomValues();


          Auth::logout();


        });

        //Get all goals as collection, then loop through and update the goal averages
        // I still am kind of shaky on why this is necessary, should readdress this later

        $all = Goal::all();

        $all->each(function($g) {
            $g->updateGoalAverages();
        });


        $mike = factory(App\User::class, 'mike')->create();
        $mike->createProfile();

    }
}
