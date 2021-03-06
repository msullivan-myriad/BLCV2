<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use App\Tag;

class CategoryGoalsFilteringRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $category = $this->route('category');

    return Tag::where('slug', $category)->exists();

  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {

    return [
      'order' => [
        'required',
        'in:cost-desc,cost-asc,hours-desc,hours-asc,days-desc,days-asc,popular-desc,popular-asc'
      ]
    ];
  }
}
