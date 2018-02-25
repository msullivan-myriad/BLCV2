<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class MostAndLeastDifficultRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    /*
    $user = Auth::user();
    $profile = $user->profile;

    $willAuthenticate = true;

    if (0 >= $profile->cost_per_year) {

      dd('gettig here');
      $willAuthenticate = false;
    }


    if ($profile->days_per_year <= 0) {
      $willAuthenticate = false;
    }

    if ($profile->hours_per_year <= 0) {
      $willAuthenticate = false;
    }

    return $willAuthenticate;
    */
    return true;

  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [

    ];
  }
}
