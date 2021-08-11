<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Sponsorship;
use Faker\Generator as Faker;

$factory->define(Sponsorship::class, function (Faker $faker) {

    return [
        //
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
        'country' => $faker->country,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'state_province' => $faker->state,
        'zip_code' => $faker->postcode,
        'child_id' => function () {
            return factory(App\Child::class)->create()->id;
        }
    ];

});
