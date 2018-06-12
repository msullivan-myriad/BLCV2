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
        'votes' => 0,
    ];

  }

}


/*
namespace App\Http\Transformers\CMS;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\SiteUser;

class SiteUserTransformer extends TransformerAbstract {

  public function transform(SiteUser $siteUser) {
    $phoneNumber = isset($siteUser->appUser) ?
      $siteUser->appUser->phoneNumbers()->first()
      : null;
    return [

      'id' => $siteUser->id,
      'description' => $siteUser->description,
      'last_login' => $siteUser->last_login ?  Carbon::parse($siteUser->last_login)->format('n/d/y g:i A') : '',
      'phone' => isset($phoneNumber) ? $phoneNumber->phone : '',
      'specs' => $siteUser->platform_name ? $siteUser->platform_name . ' ' . $siteUser->platform_version : 'N/A',
      'status' => $siteUser->status ? 'Active' : 'Deactivated',

    ];
  }

}

*/
