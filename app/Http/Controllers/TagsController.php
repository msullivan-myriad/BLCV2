<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Goal;
use Illuminate\Http\Request;


class TagsController extends Controller {

    public function view($tagSlug) {

        $tag = Tag::where('slug', $tagSlug)->first();

        return view('tags.view')->with( 'tag', $tag);
    }

    public function categoryGoalsFiltering(Request $request, $category) {

      $tag = Tag::where('slug', $category)->first();
      $tagId = $tag->id;
      $order = $request->order;

      //Get goals that have a tag id equal to the current tag id and are also in the goal_ids_array
      $initialGoals = Goal::whereHas('tags', function($query) use ($tagId) {
          $query->where('tag_id', $tagId);
      });

      if ($order == 'cost-desc') {
        $goals = $initialGoals->orderBy('cost', 'desc')->get();
      }

      else if ($order == 'cost-asc') {
        $goals = $initialGoals->orderBy('cost', 'asc')->get();
      }

      else if ($order == 'hours-desc') {
        $goals = $initialGoals->orderBy('hours', 'desc')->get();
      }

      else if ($order == 'hours-asc') {
        $goals = $initialGoals->orderBy('hours', 'asc')->get();
      }

      else if ($order == 'days-desc') {
        $goals = $initialGoals->orderBy('days', 'desc')->get();
      }

      else if ($order == 'days-asc') {
        $goals = $initialGoals->orderBy('days', 'asc')->get();
      }

      else if ($order == 'popular-desc') {
        $goals = $initialGoals->orderBy('subgoals_count', 'desc')->get();
      }

      else if ($order == 'popular-asc') {
        $goals = $initialGoals->orderBy('subgoals_count', 'asc')->get();
      }

      else {
        $goals = $initialGoals->orderBy('cost', 'desc')->get();
      }

      return [
       'data' => [
          'goals' => $goals,
       ]
      ];

    }

  public function apiPopularTags() {

    $tags = Tag::mostPopularTags()->get();

    return [

      'data' => [
        'tags' => $tags,
      ],

    ];

  }

  public function apiGoalsWithTag(Tag $tag) {

    $goals = Goal::goalsWithSpecificTag($tag->id)->paginate(3);

    return $goals;
  }


}
