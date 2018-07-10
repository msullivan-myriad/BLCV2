<?php

namespace App\Http\Requests\Subgoal;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use Illuminate\Support\Facades\Auth;

class SubgoalsSortedRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $options = ['cost-desc', 'cost-asc', 'hours-desc', 'hours-asc', 'days-desc', 'days-asc', 'popular-desc', 'popular-asc'];

    $order = $this->route('order');

    return in_array($order, $options);

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
