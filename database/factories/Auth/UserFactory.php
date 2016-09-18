<?php

use App\Models\Auth\User;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->defineAs(User::class, 'admin', function (Faker\Generator $faker)
{
    return [
        'name'               => 'The Admin',
        'email'              => 'admin@example.com',
        'password'           => bcrypt('password'),
        'remember_token'     => Str::random(60),
        'verified'           => true,
        'verification_token' => null,
    ];
});

$factory->defineAs(User::class, 'verified', function (Faker\Generator $faker)
{
    return [
        'name'               => 'A verified user',
        'email'              => 'verified@example.com',
        'password'           => bcrypt('password'),
        'remember_token'     => Str::random(60),
        'verified'           => true,
        'verification_token' => null,
    ];
});

$factory->defineAs(User::class, 'unverified', function (Faker\Generator $faker)
{
    return [
        'name'               => 'An unverified user',
        'email'              => 'unverified@example.com',
        'password'           => bcrypt('password'),
        'remember_token'     => Str::random(60),
        'verified'           => config('auth.verification.enabled') ? false : true,
        'verification_token' => config('auth.verification.enabled')
            ? hash_hmac('sha256', Str::random(40), config('app.key'))
            : null,
    ];
});

$factory->define(User::class, function (Faker\Generator $faker)
{
    return [
        'name'               => $faker->name,
        'email'              => $faker->safeEmail,
        'password'           => bcrypt('password'),
        'remember_token'     => Str::random(60),
        'verified'           => config('auth.verification.enabled') ? false : true,
        'verification_token' => config('auth.verification.enabled')
            ? hash_hmac('sha256', Str::random(40), config('app.key'))
            : null,
    ];
});