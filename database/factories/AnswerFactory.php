<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
       'body' => $faker->paragraphs(rand(1,3),true),
       'user_id' => App\User::pluck('id')->random(),
       'votes' => rand(0,100),
    ];
});
