<?php

namespace App\Http\Requests\Goal;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewGoalRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      'title' => 'required|string|max:100|unique:goals,name',
      'cost' => 'required|numeric|max:10000000000',
      'days' => 'required|numeric|max:10000',
      'hours' => 'required|numeric|max:100000',
    ];
  }
}
