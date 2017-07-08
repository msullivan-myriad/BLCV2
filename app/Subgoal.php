<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subgoal extends Model
{

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function goal() {
        return $this->belongsTo(Goal::class);
    }

}
