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

      //Need to map over votes here and see if any of the existing vote ids belong to the current user
      /*
      $experience->votes->map(function($vote) {
        echo $vote->id;
      });
      */

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

