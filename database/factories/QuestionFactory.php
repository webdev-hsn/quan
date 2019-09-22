<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(6,10)),
        'body' => $faker->paragraphs(rand(1,3), true),
        'votes' => rand(0,1000),
        'views_count' => rand(0,1000),
    ];
});
