<?php
/**
 * Created by PhpStorm.
 * User: michaelsullivan
 * Date: 6/11/18
 * Time: 5:01 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Experience;

class ExperienceTransformer extends TransformerAbstract {

  public function transform(Experience $experience) {

    return [
        'id' => $experience->id,
        'goal_id' => $experience->goal_id,
        'user_id' => $experience->user_id,
        'cost' => $experience->cost,
        'days' => $experience->days,
        'hours' => $experience->hours,
        'text' => $experience->text,
        'votes' => $experience->votes()->sum('vote'),
        'all_votes' => $experience->votes,
    ];

  }

}

