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

    public function individualTag() {
        return view('admin.individual-tag');
    }

    public function apiIndividualTag(Tag $tag) {
        //Left off here
        //Need to figure out how to do a with then where clause in laravel
        $goals = Goal::with('tags')->where('tag.id', $tag->id)->get();

        //$goals = $tag->goals;

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
