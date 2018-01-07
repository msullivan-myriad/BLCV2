<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase {

    use DatabaseTransactions;

    private $user;

    private function createBaseUser() {

      $this->user = User::create([
          'name' => 'Jonathan',
          'email' => 'jonathan@email.com',
          'password' => bcrypt('password'),
      ]);

    }

    /** @test */
    public function can_create_a_user() {

      $this->createBaseUser();

      $this->assertEquals('Jonathan', $this->user->name);
      $this->assertEquals('jonathan@email.com', $this->user->email);

      //$this->assertFalse($this->user->admin);
    }

    /** @test */
    public function can_create_an_admin_user() {

      $user = User::create([
          'name' => 'Jonathan',
          'email' => 'jonathan@email.com',
          'password' => bcrypt('password'),
          'admin' => true,
      ]);

      $this->assertEquals('Jonathan', $user->name);
      $this->assertEquals('jonathan@email.com', $user->email);

      //$this->assertTrue($user->admin);


    }


}