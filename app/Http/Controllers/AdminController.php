<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Tag;

class AdminController extends Controller
{
    public function index() {

        return view('admin.index');

    }

    public function tags() {

        $goals = Goal::with('tags')->orderBy('subgoals_count', 'desc')->get();
        //Should probably sort by popularity or something eventually
        $tags= Tag::all();

        return view('admin.tags')->with([
                'goals' =>$goals,
                'tags' => $tags,
        ]);

    }

    public function apiTags() {
        $goals = Goal::with('tags')->orderBy('subgoals_count', 'desc')->get();
        //Should probably sort by popularity or something eventually
        $tags= Tag::all();

        return [

          'data' => [
                'goals' =>$goals,
                'tags' => $tags,
          ]

        ];

    }

    public function individualTag(Tag $tag) {
        $goals = $tag->goals;
        return view('admin.individual-tag')->with([
            'goals' => $goals,
            'tag' => $tag,
        ]);
    }

    public function apiIndividualTag(Tag $tag) {

        //This is where I left off
        //This goal needs to be added to the routes
        //After that is done the AdminIndividualTagPage needs to make a request to this controller

        $goals = $tag->goals;

        return [

          'data' => [
                'goals' =>$goals,
                'tag' => $tag,
          ]

        ];

    }


    public function goal(Goal $goal) {
        return view('admin.goal')->with('goal', $goal);
    }

}
