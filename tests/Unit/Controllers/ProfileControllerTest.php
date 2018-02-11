<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;

class ProfileControllerTest extends ControllerTestCase {

  /** @test */
  function profile_information_requires_authenticated_user() {
    $this->canOnlyBeViewedBy('auth', 'GET', 'api/profile/profile-information');
  }

  /** @test */
  function profile_information_returns_proper_json_response() {
    $this->createBaseUser();
    $this->user->createProfile();
    $this->be($this->user);
    $response = $this->json('GET', 'api/profile/profile-information');

    $response->assertJson([
      'data' => [
        'profile' => [
          'user_id' => $this->user->id,
          'cost_per_year' => 0,
          'days_per_year' => 0,
          'hours_per_year' => 0,
        ]
      ]
    ]);
  }

  /** @test */
  function set_birthdate_requires_authenticated_user() {
    $this->canOnlyBeViewedBy('auth', 'POST', 'api/profile/set-birthdate', ['birthdate' => '2018-02-21']);
  }

  /** @test */
  function set_birthdate_returns_proper_json_response() {

    $this->createBaseUserWithProfile();
    $this->be($this->user);

    $request = $this->json('POST', 'api/profile/set-birthdate', ['birthdate' => '2018-02-21']);

    $request->assertJson([
      'data' => [
        'success' => 'true',
      ]
    ]);
  }

}
