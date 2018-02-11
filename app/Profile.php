<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

  /*
   *  Regular Public Methods
   */

  public function setBirthday($date) {

    //Need test for this

    $this->birthday = $date;
    $this->save();

  }

  public function setDedicatedPerYear($cost, $days, $hours) {

      //Need test for this

      $this->cost_per_year = $cost;
      $this->days_per_year = $days;
      $this->hours_per_year = $hours;

      $this->save();

  }

}
