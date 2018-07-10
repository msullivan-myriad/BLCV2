<?php

namespace App\Http\Requests\Subgoal;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use Illuminate\Support\Facades\Auth;

class SubgoalOwnedByUserRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $slug = $this->route('subgoal');

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
    return [

    ];
  }
}
