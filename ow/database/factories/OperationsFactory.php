<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Operation::class, function (Faker $faker) {
    return [
        'id_user' 				=> $faker->name,
        'id_transaction_type' 	=> $faker->name,
        'id_status_type' 		=> $faker->name,
        'value' 				=> $faker->name,
        'authorization'			=> mt_rand(100000, 999999)
    ];
});
