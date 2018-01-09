<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Snipe\BanBuilder\CensorWords;
use App\Tag;

class Goal extends Model {

    public function attachTagToGoal($name) {
      //Takes the name of the tag, checks if the tag already exists, if not creates it, then attaches the tag to the goal
      //Returns the tag id

      //Search via name here rather than id in the case the tag already exists
      $tag = Tag::where('name', $name)->first();

      //Create a new tag if the tag doesn't yet exist
      if (!$tag) {
        $tag = new Tag;

        $tag->name = $name;
        $tag->slug = str_slug($name, "-");
        $tag->count = 1;
        $tag->save();

      } else {

        $tag->count++;
        $tag->save();
      }

      $this->tags()->attach($tag);

      return $tag->id;

  }

  public function createDefaultSubgoal(User $user = null) {
    //Create subgoal using defaults of the parent goal
    // Decided to pass user through as argument to make mocking data easier
    // Might need some validation on the user here...



    //Need to fix the database seeder if I would like to get rid of the below conditional and the default of null being passed through

    if (is_null($user)) {
      $user = Auth::user();
    }

    $subgoal = new Subgoal;
    $subgoal->user_id = $user->id;
    $subgoal->goal_id = $this->id;
    $subgoal->name = $this->name;
    $subgoal->slug = $this->slug;
    $subgoal->cost = $this->cost;
    $subgoal->days = $this->days;
    $subgoal->hours = $this->hours;
    $subgoal->save();

    //Update Goal Averages
    $this->updateGoalAverages();
  }

  public function createNewSubgoal($cost, $hours, $days) {
    //Create subgoal that has different numbers than the parent goal
    $user = Auth::user();
    $subgoal = new Subgoal;
    $subgoal->user_id = $user->id;
    $subgoal->goal_id = $this->id;
    $subgoal->name = $this->name;
    $subgoal->slug = $this->slug;
    $subgoal->cost = $cost;
    $subgoal->days = $days;
    $subgoal->hours = $hours;
    $subgoal->save();

    //Update Goal Averages
    $this->updateGoalAverages();

  }

  public function deleteGoal() {
    $this->subgoals()->delete();
    $this->forceDelete();
  }

  public function editGoal($newTitle) {
    $newSlug = str_slug($newTitle, "-");
    $this->subgoals()->update([
      'name' => $newTitle,
      'slug' => $newSlug,
    ]);
    $this->name = $newTitle;
    $this->slug = $newSlug;
    $this->save();
  }

  public static function allGoals() {
    //All goals sorted by their popularity
    $all_goals = self::orderBy('subgoals_count', 'desc');
    return $all_goals;
  }

  public static function allGoalsWithTags() {
    //All goals with tags, sorted by their popularity
    $all_goals = self::allGoals()->with('tags');
    return $all_goals;
  }

  public static function goalsWithSpecificTag($tagId) {

    $goals = self::whereHas('tags', function ($query) use ($tagId) {
      $query->where('tags.id', '=', $tagId);
    })->with('tags');

    return $goals;

  }

  public function removeTagFromGoal($tagId) {

    $tag = Tag::where('id', $tagId)->first();
    $this->tags()->detach($tag);
    $tag->count--;
    $tag->save();

  }

  public function setNameAttribute($value) {
    //Temporarily remove the censorship

    //$censor = new CensorWords;
    //$censor->setDictionary('../resources/lang/CensoredWords.php');
    //$stringCensored = $censor->censorString($value);
    //$formattedAndCensored = ucwords(strtolower($stringCensored['clean']));
    //$this->attributes['name'] = $formattedAndCensored;

    $this->attributes['name'] = ucwords(strtolower($value));
  }

  public function subgoals() {
    return $this->hasMany(Subgoal::class);
  }

  public function tags() {
    return $this->belongsToMany(Tag::class);
  }

  public function updateGoalAverages() {
    //Update the parent goal to match the subgoals average
    $count = $this->subgoals->count();

    if ($count) {
      $this->subgoals_count = $count;
      $this->cost = round($this->subgoals->avg('cost'));
      $this->days = round($this->subgoals->avg('days'));
      $this->hours = round($this->subgoals->avg('hours'));
      $this->save();
    } else {
      $this->forceDelete();
    }

    //  I have some work to do here... gettype returns a float, at least sometimes.
    //  But after checking it apprears that the other numbers are returning strings....
    //  I was expecting integers, are there stringsin in the database?  Need to look into this
    //  Using average should work for now

  }


}
