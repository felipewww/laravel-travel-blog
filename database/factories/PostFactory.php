<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
 * Run Examples
 *
 * factory('Painel\Post', $qtt)->states('Cities')->make([$attributes]);
 * */

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->state(Painel\World\Post::class, 'City', function (Faker\Generator $faker) {
    return Painel\World\Post::defaultFakeFields('Painel\World\City');
});

$factory->state(Painel\World\Post::class, 'Estate', function (Faker\Generator $faker) {
    return Painel\World\Post::defaultFakeFields('Painel\World\Estate');
});

$factory->define(Painel\World\Post::class, function (Faker\Generator $faker) use ($factory){
    return [
        'title'         => $faker->paragraph(1),
        'content'       => $faker->text(),
        'content_strip' => $faker->text(),
        'post_types_id'  => 1,
        'authors_id'    => Painel\World\Authors::all()->random(1)->id,
    ];
});
