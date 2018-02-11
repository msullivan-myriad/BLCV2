<?php

namespace Tests\Unit;

use App\Profile;
use App\User;
use Tests\TestCase;

class ProfileModelTest extends TestCase {

  /** @test */
  public function profile_can_set_birthdate() {

    $this->createBaseUserWithProfile();

    $this->assertNull($this->user->profile->birthday);

    $this->user->profile->setBirthday("2018-02-21");

    $this->assertEquals($this->user->profile->birthday, '2018-02-21');

  }

  /** @test */
  /*
  public function profile_can_set_dedicated_per_year() {

    $this->createBaseUserWithProfile();

    $this->assertNull($this->user->profile->birthday);

    $this->user->profile->setBirthday("2018-02-21");

    $this->assertEquals($this->user->profile->birthday, '2018-02-21');

  }
  */

}
