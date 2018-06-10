<?php

namespace Tests;

use App\User;
use Illuminate\Support\Facades\Auth;

abstract class ControllerTestCase extends TestCase {


    protected function canBeViewedByAnyone($url, $array = false) {

      if ($array) {
        $response = $this->json('GET', $url, $array);
        $response->assertStatus(200);
      }
      else {
        $response = $this->get($url);
        $response->assertStatus(200);
      }
    }

    protected function canOnlyBeViewedBy($userType, $postType, $url, $array = false) {

      Auth::logout();

      if($userType == 'admin') {
        $user = factory(User::class, 'admin')->create();
        $user->createProfile();

      }
      else if ($userType == 'auth') {
        $user = factory(User::class, 'base-test-user')->create();
        $user->createProfile();
      }
      else if ($userType == 'use-existing') {
        $user = $this->user;
      }
      else if ($userType == 'use-alternate') {
        $user = $this->alternateUser;
      }

      if ($postType == 'GET') {

        $request = $this->get($url);
        $secondRequest = $this->actingAs($user)->get($url);

      }

      else if ($postType == 'POST') {

        if ($array) {
          $request = $this->post($url, $array);
          $secondRequest = $this->actingAs($user)->post($url, $array);
        }
        else {
          $request = $this->post($url);
          $secondRequest = $this->actingAs($user)->post($url);
        }
      }

      else if ($postType == 'DELETE') {

        if ($array) {
          $request = $this->delete($url, $array);
          $secondRequest = $this->actingAs($user)->delete($url, $array);
        }
        else {
          $request = $this->delete($url);
          $secondRequest = $this->actingAs($user)->delete($url);
        }
      }

      else {
        $this->assertTrue(false);
      }

      $request->assertStatus(302);
      $secondRequest->assertStatus(200);

    }


}
