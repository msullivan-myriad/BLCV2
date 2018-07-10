<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Goal;
use App\Http\Requests\Experience\AddNewExperienceToGoalRequest;
use App\Http\Requests\Experience\EditExperienceRequest;
use App\Http\Requests\Experience\UpvoteExperienceRequest;
use App\Http\Requests\Experience\DownvoteExperienceRequest;
use App\Vote;
use Exception;
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

    return new JsonResponse([
      'vote_id' => $vote->id,
    ], 200);

  }

  public function downVoteExperience(DownvoteExperienceRequest $request, Experience $experience) {

    $vote = new Vote();
    $vote->vote = -1;
    $vote->experience()->associate($experience);
    $vote->user()->associate(Auth::user());
    $vote->save();

    return new JsonResponse([
      'vote_id' => $vote->id,
    ], 200);

  }

  public function removeVoteFromExperience(Request $request, Experience $experience) {

    //I don't think additional validation is very necessary here.  In order for a user
    //to even be able to have a vote to remove they would have had to go through validation
    //already.  If nothing exists when the below where clause runs, nothing happens
    $vote = $experience->votes()->where('user_id', '=', Auth::user()->id)->first();

    $deletedVoteId = '';

    try {

      $deletedVoteId = $vote->id;
    }

    catch(Exception $exception) {}

    $experience->votes()->where('user_id', '=', Auth::user()->id)->delete();

    return new JsonResponse([
      'deleted_vote_id' => $deletedVoteId,
    ], 200);

  }

}

