<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Goal;
use App\Http\Requests\AddNewExperienceToGoalRequest;
use App\Http\Requests\EditExperienceRequest;
use App\Http\Requests\UpvoteExperienceRequest;
use App\Vote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Transformers\ExperienceTransformer;

class ExperienceController extends Controller {

  private $experienceTransformer;

  public function __construct(ExperienceTransformer $experienceTransformer) {
    $this->experienceTransformer = $experienceTransformer;
  }

  public function viewGoalsExperiences(Goal $goal) {

    return $goal->experiences->map(function($experiences) {
      return $this->experienceTransformer->transform($experiences);
    });

  }

  public function addNewExperienceToGoal(AddNewExperienceToGoalRequest $request, Goal $goal) {

    $experience = new Experience();

    $experience->cost = $request->cost;
    $experience->days = $request->days;
    $experience->hours = $request->hours;
    $experience->text = $request->text;
    //$experience->votes = 0;

    $experience->user()->associate(Auth::user()->id);
    $experience->goal()->associate($goal);
    $experience->save();

    return new JsonResponse('success', 200);

  }

  public function editExperience(EditExperienceRequest $request, Experience $experience) {

    $experience->cost = $request->cost;
    $experience->days = $request->days;
    $experience->hours = $request->hours;
    $experience->text = $request->text;
    $experience->save();

    return new JsonResponse('success', 200);

  }

  public function upVoteExperience(UpvoteExperienceRequest $request, Experience $experience) {

    $vote = new Vote();
    $vote->vote = 1;
    $vote->experience()->associate($experience);
    $vote->user()->associate(Auth::user());
    $vote->save();

    return new JsonResponse('success', 200);

  }

  public function downVoteExperience(Request $request, Experience $experience) {
    return JsonResponse('success', 200);
  }


}

