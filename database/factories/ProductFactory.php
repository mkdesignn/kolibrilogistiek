<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Product::class, function (Faker $faker) {

    $user = \App\User::whereIn('role', [\App\Utils\Enums\Role::SUPPLIER])->inRandomOrder()->first();
    return [
        'name' => $faker->name,
        'sku' => $faker->languageCode,
        'qty' => random_int(1, 1000),
        'thumbnail' => $faker->imageUrl(),
        'user_id' => $user->id,
    ];
});
