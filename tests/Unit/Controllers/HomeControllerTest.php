<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;

class HomeControllerTest extends ControllerTestCase {


  /** @test */
  public function index_requires_authentication() {

    $this->canOnlyBeViewedBy('auth', 'GET', '/home');

  }

}
