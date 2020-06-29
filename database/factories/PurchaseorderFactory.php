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

$factory->define(App\Purchaseorder::class, function (Faker $faker) {

    $customer = factory(\App\User::class)->create(['role'=>'customer']);
    $supplier = factory(\App\User::class)->create(['role'=>'supplier']);

    $randomNumber = random_int(1, 120);
    return [
        'status' => 1,
        'user_id' => $customer->id,
        'customer_id' => $customer->id, // secret
        'supplier_id' => $supplier->id,
        'number' => str_random(10),
        'received_at' => now()->subDays($randomNumber + 10)->toDateTimeString(),
        'expected_at' => now()->subDays($randomNumber + 15)->toDateTimeString(),
        'shipped_at' => now()->subDays($randomNumber + 5)->toDateTimeString(),
        'trackandtrace' => $faker->text,
        'uuid' => Ramsey\Uuid\Uuid::getFactory()->uuid4()
    ];
});
