<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use Illuminate\Support\Facades\Auth;

class IndividualGoalStatsRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $slug = $this->route('slug');

    return Subgoal::where('slug', $slug)
      ->where('user_id', Auth::id())
      ->exists();

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
