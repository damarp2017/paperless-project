<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Store::class, function (Faker $faker) {
    $user = factory(\App\User::class)->create();
    return [
        'owner_id' => $user->id,
        'name' => $faker->name,
        'description' => $faker->words(3, true),
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/store-logo/200727194914-boy.png',
    ];
});
