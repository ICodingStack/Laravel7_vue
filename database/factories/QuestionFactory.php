<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
       //rtrim delete the .
        'title'=>rtrim($faker->sentence(rand(5,10)),'.'),
        //with true value give me new line in paragraph
        'body'=>$faker->paragraph(rand(3,7),true),
        'views'=>rand(0,10),
//        'answers_count'=>rand(0,10),
//        'votes_count'=>rand(-3,10),
    ];
});
