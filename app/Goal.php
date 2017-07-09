<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Goal extends Model
{

    /*
    protected $fillable = [
        'name', 'cost', 'time'
    ];
    */

    public function createDefaultSubgoal() {
        //Create subgoal using defaults of the parent goal
        $user = Auth::user();
        $subgoal = new Subgoal;
        $subgoal->user_id = $user->id;
        $subgoal->goal_id = $this->id;
        $subgoal->name = $this->name;
        $subgoal->cost = $this->cost;
        $subgoal->days = $this->days;
        $subgoal->hours = $this->hours;
        $subgoal->save();
        $this->subgoals_count += 1;
        $this->save();

    }

    public function createNewSubgoal($cost, $hours, $days) {
        //Create subgoal that has different numbers than the parent goal

        $user = Auth::user();
        $subgoal = new Subgoal;
        $subgoal->user_id = $user->id;
        $subgoal->goal_id = $this->id;
        $subgoal->name = $this->name;
        $subgoal->cost = $cost;
        $subgoal->days = $days;
        $subgoal->hours = $hours;
        $subgoal->save();

        //Need to update the parent goal here
        $this->subgoals_count +=1;
        $this->save();
    }

    public function subgoals() {
        return $this->hasMany(Subgoal::class);
    }


}
