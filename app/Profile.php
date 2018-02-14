<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

  /*
   *  Regular Public Methods
   */

  public function setBirthday($date) {

    $this->birthday = $date;
    $this->save();

  }

  public function setDedicatedPerYear($cost, $days, $hours) {

      $this->cost_per_year = $cost;
      $this->days_per_year = $days;
      $this->hours_per_year = $hours;

      $this->save();

  }

}
