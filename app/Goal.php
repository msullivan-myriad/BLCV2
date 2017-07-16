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

    public function createDefaultSubgoal(User $user) {
        //Create subgoal using defaults of the parent goal
        // Decided to pass user through as argument to make mocking data easier
        // Might need some validation on the user here...
        $subgoal = new Subgoal;
        $subgoal->user_id = $user->id;
        $subgoal->goal_id = $this->id;
        $subgoal->name = $this->name;
        $subgoal->cost = $this->cost;
        $subgoal->days = $this->days;
        $subgoal->hours = $this->hours;
        $subgoal->save();

        //Update Goal Averages
        $this->updateGoalAverages();
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

        //Update Goal Averages
        $this->updateGoalAverages();

    }

    public function updateGoalAverages() {
        //Update the parent goal to match the subgoals average
        $count = $this->subgoals->count();

        if($count) {
            $this->subgoals_count = $count;
            $this->cost = round($this->subgoals->avg('cost'));
            $this->days = round($this->subgoals->avg('days'));
            $this->hours = round($this->subgoals->avg('hours'));
            $this->save();
        }

        else {
            $this->forceDelete();
        }

        //  I have some work to do here... gettype returns a float, at least sometimes.
        //  But after checking it apprears that the other numbers are returning strings....
        //  I was expecting integers, are there stringsin in the database?  Need to look into this
        //  Using average should work for now

    }

    public function subgoals() {
        return $this->hasMany(Subgoal::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

}
