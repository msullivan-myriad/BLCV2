<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

  public function experience() {
    return $this->belongsTo(Experience::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }

}
