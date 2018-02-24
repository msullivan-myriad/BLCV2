<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class ViewIndividualTagRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $tag = $this->route('tag');

    return Tag::where('slug', $tag)->exists();

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
