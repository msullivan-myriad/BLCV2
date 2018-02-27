<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use Illuminate\Support\Facades\Auth;

class TargetCompletionAgeRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {


    $age = $this->route('age');
    $user = Auth::user();
    $profile = $user->profile;

    $current_age_in_days = $profile->getCurrentAgeInDays();
    $completion_age_in_days = round(($age * 365.25));


    $willAuthenticate = true;

    if (!preg_match('/^[0-9]+$/', $age)) {
      $willAuthenticate = false;
    }

    if ($current_age_in_days >= $completion_age_in_days) {
      $willAuthenticate = false;
    }

    if ($profile->cost_per_year <= 0) {
      $willAuthenticate = false;
    }

    if ($profile->days_per_year <= 0) {
      $willAuthenticate = false;
    }

    if ($profile->hours_per_year <= 0) {
      $willAuthenticate = false;
    }

    if (!$profile->birthday) {
      $willAuthenticate = false;
    }


    return $willAuthenticate;

  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [];
  }
}
