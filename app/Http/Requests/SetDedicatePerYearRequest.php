<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetDedicatePerYearRequest extends FormRequest {

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
      'cost_per_year' => 'required|integer',
      'days_per_year' => 'required|integer',
      'hours_per_year' => 'required|integer',
    ];
  }
}
