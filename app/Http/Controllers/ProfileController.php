<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function view() {

        $user_profile = Auth::user()->profile;

        return view('profile.edit')->with('profile', $user_profile);

    }

    public function edit(Request $request) {

        $this->validate($request, [
            'age' => 'required|numeric|min:1|max:150',
        ]);

        $profile = Auth::user()->profile;

        $profile->age = $request->age;

        $profile->save();

        return back();

    }

}
