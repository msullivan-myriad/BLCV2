<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DownvoteExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

      $experience = $this->route('experience');

      $usersWithVote = $experience->votes->map(function($vote) {
        return $vote->user_id;
      });

      $user = Auth::user();

      $usersIndex = $usersWithVote->search($user->id);

      //$usersIndex above will return false if it finds nothing, however search returns the index
      //of the user->id if it exists.  This means that the index of 0 could potentially
      //Be a valid response.  This is the reason for the strict comparison below

      if ($usersIndex === false) {

        if (Auth::user()->id == $experience->user_id) {
          return false;

        }
        else {
          return true;
        }

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

        return [];

    }


}

