<?php

namespace App;

use const EXIF_USE_MBSTRING;
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
        'name', 'email', 'password', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*
     *  Regular Public Methods
     */

    public function createProfile() {
        $profile = new Profile;
        $profile->user_id = $this->id;
        $profile->save();
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function subgoals() {
        return $this->hasMany(Subgoal::class);
    }

    public function experiences() {
      return $this->hasMany(Experience::class);
    }

    public function votes() {
      return $this->hasMany(Vote::class);
    }

}
