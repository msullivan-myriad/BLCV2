<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller {

    public function setDedicatedPerYear(Request $request) {
      //Need some auth here

      $user = Auth::user();

      $profile = $user->profile;

      $profile->cost_per_year = $request->cost_per_year;
      $profile->days_per_year = $request->days_per_year;
      $profile->hours_per_year = $request->hours_per_year;

      $profile->save();

      return $request;

    }

    public function profileInformation() {

      $user = Auth::user();

      $profile = $user->profile;

      return [
        'data' => [
          'profile' => $profile,
        ]
      ];

    }

    public function setBirthdate(Request $request) {

      $user = Auth::user();

      $profile = $user->profile;

      $profile->birthday = $request->birthdate;

      $profile->save();

      return [
        'data' => [
          'success' => true,
        ]
      ];

    }

}
