<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;

class AdminController extends Controller
{
    public function index() {

        return view('admin.index');

    }

    public function tags() {

        $goals = Goal::with('tags')->get();

        return view('admin.tags')->with('goals', $goals);

    }
}
