<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public function goals() {
        return $this->belongsToMany(Goal::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    /*
    public function subgoals() {
      //Need to figure out what to do here...
      //$test = $this->id;
      //return $test;
      return $this->belongsToMany(Goal::class);
    }
    */

}
