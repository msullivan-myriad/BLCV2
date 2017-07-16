<?php

use Illuminate\Database\Seeder;
use App\Goal;
use App\User;
use App\Subgoal;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 50)->create()->each(function ($user) {
            $goalName = 'TEST';
            $goalCost = 11;
            $goalHours = 3;
            $goalDays = 2;
            $user->newGoal($goalName, $goalCost, $goalHours, $goalDays);
        });


        // I think I should move away from this approach an move towards creating everything with model factories.
        // This would allow me to use faker and create everything much easier... the relationship between goals and subgoals could still be tricky
        // I could then run 'updateGoalAverages' on every single goal manually after everything else is finished up
    }
}
