<?php

use App\Models\Auth\User;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker\Generator $faker)
{
    return [
        'name'               => $faker->name,
        'email'              => $faker->safeEmail,
        'password'           => bcrypt(str_random(10)),
        'remember_token'     => str_random(10),
        'verified'           => config('auth.verification.enabled') ? false : true,
        'verification_token' => config('auth.verification.enabled')
            ? hash_hmac('sha256', Str::random(40), config('app.key'))
            : null,
    ];
});