<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Subgoal;
use App\Goal;
use Illuminate\Support\Facades\Auth;

class GetUsersIndividualTagRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {

    $tag = $this->route('tag');
    $user = Auth::user();

    $subgoals = Subgoal::with('goal')->where('user_id', $user->id)->get();

    //Create an array of all the goal ids associated with the users subgoals
    $goal_ids_array = [];

    foreach ($subgoals as $sub) {
      array_push($goal_ids_array, $sub->goal->id);
    }

    //Get goals that have a tag id equal to the current tag id and are also in the goal_ids_array
    return Goal::whereHas('tags', function ($query) use ($tag, $goal_ids_array) {
      $query->where('tag_id', $tag->id)->whereIn('goal_id', $goal_ids_array);
    })->exists();

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
