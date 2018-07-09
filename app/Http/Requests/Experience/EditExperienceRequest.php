<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

      $experience = $this->route('experience');

      if (Auth::user()->id == $experience->user_id) {
        return true;
      }
      else {
        return false;
      }

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
            'text' =>  'required|string',
        ];
    }

}

