<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/store-logo/200727194914-boy.png',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'api_token' => Str::random(80),
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'), // password
        'remember_token' => Str::random(10),
    ];
});
