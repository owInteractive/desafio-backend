<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Transaction::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(1,8000),
        'transaction_type' => $faker->randomElement(['credit','debit','reversal']),
    ];
});
