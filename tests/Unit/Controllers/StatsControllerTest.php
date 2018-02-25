<?php

namespace Tests\Unit;

use Tests\ControllerTestCase;

class StatsControllerTest extends ControllerTestCase {

  /** @test */
  public function totals_requires_authenticated_user() {

    $this->createBaseGoalWithSubgoal();
    $this->canOnlyBeViewedBy('use-existing', 'GET', 'api/stats/totals');
  }


}
