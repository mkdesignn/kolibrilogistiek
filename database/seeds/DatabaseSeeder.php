<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);

        factory(\App\Purchaseorder::class, 30)->create()->each(function($purchaseOrder){
            factory(\App\Purchaseorderlines::class)
                ->create([
                    'purchaseorder_id'=>$purchaseOrder->id,
                    'user_id'=>$purchaseOrder->user_id
                ]);
        });
    }
}
