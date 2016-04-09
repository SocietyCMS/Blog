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
use Illuminate\Support\Str;

$factory->define(\Modules\Blog\Entities\Article::class, function (Faker\Generator $faker) {

    return [
        'title' => $title = $faker->sentence,
        'slug' => Str::slug($title),
        'body' => $faker->paragraphs($faker->numberBetween(2, 20) , true),
        'published' => $faker->boolean(80),
        'pinned' => $faker->boolean(10),
        'user_id' => $faker->randomElement(\Modules\User\Entities\Entrust\EloquentUser::all()->lists('id')->toArray()),
        'created_at' => $start = $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeBetween($start),
    ];
});
