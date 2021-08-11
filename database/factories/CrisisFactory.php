<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Crisis;
use Faker\Generator as Faker;

$factory->define(Crisis::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, 0,1000),
        'frequency' => $faker->randomElement(['Monthly', 'One Time']),
        'sponsor_id' => function () {
            return factory(App\Sponsorship::class)->create()->id;
        }
    ];
});
