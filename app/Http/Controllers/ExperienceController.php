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
    //This breaks stuff right now, may need a transformer to do this
    //return $goal->experiences()->with('votes')->get();

    /*
    return $goal->experiences()->map(function($experiences) {
      return $this->experienceTransformer->transform($experiences);
    });
    */
    return $goal->experiences()->get();
  }

  public function addNewExperienceToGoal(AddNewExperienceToGoalRequest $request, Goal $goal) {

    $experience = new Experience();

    $experience->cost = $request->cost;
    $experience->days = $request->days;
    $experience->hours = $request->hours;
    $experience->text = $request->text;
    //Should not set a vote count here
    $experience->votes = 0;

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

  public function upVoteExperience(UpvoteExperienceRequest$request, Experience $experience) {

    $vote = new Vote();
    $vote->vote = 1;
    $vote->experience()->associate($experience);
    $vote->user()->associate(Auth::user());
    $vote->save();

    //$experience->votes++;
    //$experience->save();

    return new JsonResponse('success', 200);

  }

  public function downVoteExperience(Request $request, Experience $experience) {
    return JsonResponse('success', 200);
  }


}



/*

namespace App\Http\Controllers\CMS\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Transformers\CMS\ModuleTransformer;
use App\Http\Transformers\CMS\SiteTransformer;
use App\Http\Transformers\CMS\SiteUserTransformer;
use App\Http\Requests\CMS\Users\AdminDashboardRequest;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller {

  private $siteTransformer;
  private $moduleTransformer;
  private $siteUserTransformer;

  public function __construct(SiteTransformer $siteTransformer, ModuleTransformer $moduleTransformer, SiteUserTransformer $siteUserTransformer) {
    $this->siteTransformer = $siteTransformer;
    $this->moduleTransformer = $moduleTransformer;
    $this->siteUserTransformer = $siteUserTransformer;
  }

  public function index(AdminDashboardRequest $request) {
    $user = Auth::user();
    $siteAdminId = $request->input('siteAdminId');
    $siteAdmin = $user->is_tk_admin && isset($siteAdminId) ? User::where('id', '=', $siteAdminId)->first() : $user;
    $siteAdmin->load(['sites']);
    $site = $siteAdmin->sites()->first();
    $site->load(['modules', 'territory']);

    return view('cms.admin-dashboard.index',
      [
        'site' => $this->siteTransformer->transform($site),
        'siteAdminId' => $siteAdminId,
        'siteModules' => $site->modules->map(function($module) {
          return $this->moduleTransformer->transform($module);
        }),
      ]
    );
  }

}
*/
