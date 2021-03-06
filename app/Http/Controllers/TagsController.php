<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Goal;
use App\Http\Requests\Tags\CategoryGoalsFilteringRequest;
use App\Http\Requests\Tags\ViewIndividualTagRequest;
use App\Http\Requests\Tags\ApiPopularTagsRequest;
use App\Http\Requests\Tags\ApiTagsSearchRequest;
use TomLingham\Searchy\Facades\Searchy;

class TagsController extends Controller {

    public function view(ViewIndividualTagRequest $request, $tagSlug) {

        $tag = Tag::where('slug', $tagSlug)->first();
        return view('tags.view')->with( 'tag', $tag);

    }

    public function categoryGoalsFiltering(CategoryGoalsFilteringRequest $request, $category) {

      $tag = Tag::where('slug', $category)->first();
      $tagId = $tag->id;
      $order = $request->order;
      $goals = false;

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

      return [
       'data' => [
          'goals' => $goals,
       ]
      ];

    }

  public function apiPopularTags(ApiPopularTagsRequest $request) {

    $count = $request->count;

    $tags = Tag::mostPopularTags()->take($count)->get();

    return [

      'data' => [
        'tags' => $tags,
      ],

    ];

  }

  public function apiGoalsWithTag(Tag $tag) {

    $goals = Goal::goalsWithSpecificTag($tag->id)
      ->orderBy('subgoals_count', 'desc')
      ->paginate(8);

    return $goals;

  }


  public function apiTagsSearch(ApiTagsSearchRequest $request) {

    $term = $request->term;
    $results = Searchy::search('tags')->fields('name')->query($term)->get();

    return $results;

  }


}
