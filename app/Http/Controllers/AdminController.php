<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;

class AdminController extends Controller
{
    public function index() {

        $goals = Goal::all();

        return view('admin.index')->with('goals', $goals);
    }
}
