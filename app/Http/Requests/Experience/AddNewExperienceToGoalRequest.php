<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddNewExperienceToGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

        $goal = $this->route('goal');

        $existingExperience = $goal->experiences()->where('user_id', '=', Auth::user()->id)->first();

        if (!$existingExperience) {
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

