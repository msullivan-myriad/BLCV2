<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

  public static function mostPopularTags() {
    //Return all tags from most to least popular
    $tags = self::orderBy('count', 'desc')->get();
    return $tags;
  }

  public function goals() {
    return $this->belongsToMany(Goal::class);
  }

  public function setNameAttribute($value) {
    $this->attributes['name'] = ucwords(strtolower($value));
  }

}
