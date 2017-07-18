<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    public function goals() {
        return $this->belongsToMany(Goal::class);
    }
}
