<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\SetBirthdateRequest;
use App\Http\Requests\Profile\SetDedicatePerYearRequest;

class ProfileController extends Controller {


    public function profileInformation() {

      $user = Auth::user();

      $profile = $user->profile;

      return [
        'data' => [
          'profile' => $profile,
        ]
      ];

    }

    public function setBirthdate(SetBirthdateRequest $request) {

      $user = Auth::user();

      $profile = $user->profile;

      $profile->setBirthday($request->birthdate);

      return [
        'data' => [
          'success' => true,
        ]
      ];

    }

    public function setDedicatedPerYear(SetDedicatePerYearRequest $request) {

      $user = Auth::user();

      $profile = $user->profile;

      $profile->setDedicatedPerYear($request->cost_per_year, $request->days_per_year, $request->hours_per_year);

      //This was the old return... Changing it doesn't seem to break anything
      //return $request;

      return [
        'data' => [
          'success' => true,
        ]
      ];


    }


}
