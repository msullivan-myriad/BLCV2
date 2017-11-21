<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function dedicatedPerYear() {

      $user = Auth::user();

      $profile = $user->profile;

      return [
        'data' => [
          'cost_per_year' => $profile->cost_per_year,
          'days_per_year' => $profile->days_per_year,
          'hours_per_year' => $profile->hours_per_year,
        ]
      ];

    }

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

}
