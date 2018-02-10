<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Tag;


class AdminController extends Controller {

    public function apiIndividualTag(Tag $tag) {

        $id = $tag->id;
        $goals = Goal::goalsWithSpecificTag($id)->get();

        return [

          'data' => [
                'goals' =>$goals,
                'tag' => $tag,
          ]

        ];

    }

    public function apiTags() {

        $goals = Goal::allGoalsWithTags()->get();
        $tags= Tag::mostPopularTags();

        return [

          'data' => [
                'goals' =>$goals,
                'tags' => $tags,
          ]

        ];

    }

    public function goal(Goal $goal) {
        return view('admin.goal')->with('goal', $goal);
    }


    public function index() {

        return view('admin.index');

    }

    public function individualTag() {
        return view('admin.individual-tag');
    }

    public function tags() {

        $goals = Goal::allGoalsWithTags()->get();
        $tags= Tag::mostPopularTags();

        return view('admin.tags')->with([
                'goals' =>$goals,
                'tags' => $tags,
        ]);

    }


}
