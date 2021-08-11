<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Child;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

$factory->define(Child::class, function (Faker $faker) {

    //
    $image = $faker->image(null, 300, 300, 'people');
    $imageFile = new File($image);

    $date_of_birth = Carbon::parse($faker->dateTimeBetween('-20 years', 'now'))->format('Y-m-d');

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'Country' => $faker->country,
        'gender' => $faker->randomElement(['Boy', 'Girl']),
        'date_of_birth' => $date_of_birth,
        'photo' => Storage::disk('public')->putFile('images', $imageFile),
        'hobbies' => $faker->sentence,
        'history' => $faker->paragraph,
        'support_amount' => $faker->randomFloat(2, 0,1000),
        'frequency' => $faker->randomElement(['Monthly', 'One Time']),
    ];
});
