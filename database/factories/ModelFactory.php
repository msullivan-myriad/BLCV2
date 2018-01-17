<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

/*
 *  User Factories
 */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
        'admin' => false,
    ];
});

$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
        'admin' => true,
    ];
});

$factory->defineAs(App\User::class, 'mike', function() {

    return [
        'name' => 'Mike',
        'email' => 'mike@email.com',
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'admin' => true,
    ];
});

$factory->defineAs(App\User::class, 'base-test-user', function() {

    return [
        'admin' => true,
        'name' => 'Jonathan',
        'email' => 'jonathan@email.com',
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'admin' => false,
    ];
});

/*
 *  Goal Factories
 */

$factory->define(App\Goal::class, function (Faker\Generator $faker) {

  $theName = $faker->unique()->sentence(3, true);
  $theSlug = str_slug($theName, "-");

  return [
    'name' => $theName,
    'slug' => $theSlug,
    'cost' => rand(0, 10000),
    'hours' => rand(0, 300),
    'days' => rand(0,30),
    'subgoals_count' => 0,
  ];

});

$factory->defineAs(App\Goal::class, 'base-test-goal', function () {

  return [
    'name' => 'Test Goal Name',
    'slug' => 'test-goal-name',
    'cost' => 700,
    'hours' => 100,
    'days' => 10,
    'subgoals_count' => 0,
  ];

});
