<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function subgoals() {
        return $this->hasMany(Subgoal::class);
    }

    public function createProfile() {
        $profile = new Profile;
        $profile->user_id = $this->id;
        $profile->save();
    }

    public function newGoal($name, $cost, $hours, $days) {
        // Creates a new parent goal, as well as a child goal
        $goal = new Goal;
        $goal->name = $name;
        $goal->cost = $cost;
        $goal->days = $days;
        $goal->hours= $hours;
        $goal->save();
        $goal->createSubgoal($this);
        // Still need to make sure goal without this name exists, etc.
    }

    public function addGoal(Goal $goal) {
        //Creates a subgoal with the goal it takes as an argument as it's parent goal
        $goal->createSubgoal($this);
        // Still needs to make sure the user doesn't already have this goal on their list
    }

}
