<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subgoal extends Model {

    /*
     *  Regular Public Methods
     */

    public function goal() {
        return $this->belongsTo(Goal::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
