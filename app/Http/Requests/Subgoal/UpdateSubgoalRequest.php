<?php

namespace App\Http\Requests\Subgoal;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use Illuminate\Support\Facades\Auth;

class UpdateSubgoalRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $subgoal = $this->route('subgoal');

    return Subgoal::where('id', $subgoal->id)
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
      'cost' => 'required|numeric|max:10000000000',
      'days' => 'required|numeric|max:10000',
      'hours' => 'required|numeric|max:100000',
    ];
  }
}
