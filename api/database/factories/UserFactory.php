<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'password' => '1234567',
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'social_provider_id' => 1,
        'verified' => 1,
        'verified_token' => $faker->sha1
    ];
});
