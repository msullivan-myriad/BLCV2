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
