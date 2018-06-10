<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpvoteExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

      $experience = $this->route('experience');

      if (Auth::user()->id == $experience->user_id) {
        return false;

      }
      else {
        return true;
      }

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

