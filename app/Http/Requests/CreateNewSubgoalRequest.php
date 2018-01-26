<?php

namespace App\Http\Requests;


use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateNewSubgoalRequest extends FormRequest
{
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
    public function rules()
    {
        $user = Auth::user();
        return [
            'cost' => 'required|numeric|max:10000000000',
            'days' => 'required|numeric|max:10000',
            'hours' => 'required|numeric|max:100000',
            'goal_id' => [
                'required',
                //Require that subgoal is unique, but only to the auth user
                Rule::unique('subgoals')->where('user_id', $user->id),
            ],
        ];
    }

}

