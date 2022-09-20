<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'birthday' => Carbon::create(rand(1960, 2000), rand(1, 12), rand(1, 28)),
        'opening_balance' => 0,
        'created_at' => date("Y-m-d H:i:s"),
    ];
});
