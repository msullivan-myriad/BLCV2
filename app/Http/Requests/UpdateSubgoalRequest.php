<?php

namespace App\Http\Requests;

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

    /*
    $id = $this->route('subgoal');

    return Subgoal::where('id', $id)
      ->where('user_id', Auth::id())
      ->exists();
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
