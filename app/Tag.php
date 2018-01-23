<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

  /*
   *  Static Methods
   */

  public static function mostPopularTags() {
    //Return all tags from most to least popular
    $tags = self::orderBy('count', 'desc')->get();
    return $tags;
  }

  /*
   *  Regular Public Methods
   */

  public function goals() {
    return $this->belongsToMany(Goal::class);
  }

  public function setNameAttribute($value) {
    $this->attributes['name'] = ucwords(strtolower($value));
  }

}
