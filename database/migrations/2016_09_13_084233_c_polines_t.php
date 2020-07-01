<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CPolinesT extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorderlines', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('purchaseorder_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('received_by')->unsigned()->default(0);
            $table->string('batch')->nullable();
            $table->date('expire_date')->nullable();

            $table->integer('quantity')->unsigned();
            $table->integer('quantity_received')->unsigned()->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchaseorderlines');
    }
}
