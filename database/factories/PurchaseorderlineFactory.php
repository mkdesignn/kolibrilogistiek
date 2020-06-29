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

$factory->define(App\Purchaseorderlines::class, function (Faker $faker) {

    $purchaseOrder = factory(\App\Purchaseorder::class)->create();

    return [
        'purchaseorder_id' => $purchaseOrder->id,
        'product_id' => factory(\App\Product::class)->create()->id,
        'user_id' => $purchaseOrder->user_id,
        'received_by' => 1,
        'quantity' => 1,
        'quantity_received' => 1,
        'lineDetails' => 1,
    ];
});
