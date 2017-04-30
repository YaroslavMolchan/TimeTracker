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
use App\Entities\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'google_user_id' => rand(100000, 999999),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl()
    ];
});
