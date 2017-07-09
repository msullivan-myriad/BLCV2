<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{

    /*
    protected $fillable = [
        'name', 'cost', 'time'
    ];
    */

    public function createSubgoal(User $user) {
        $subgoal = new Subgoal;
        $subgoal->user_id = $user->id;
        $subgoal->goal_id = $this->id;
        $subgoal->name = $this->name;
        $subgoal->cost = $this->cost;
        $subgoal->days = $this->days;
        $subgoal->hours = $this->hours;
        $subgoal->save();
    }

    public function subgoals() {
        return $this->hasMany(Subgoal::class);
    }

    public function subgoalsCount() {
        //Nothing here for now.. Going to have an actual column in the database rather than calculating it or needing to eager load stuff
    }

}
