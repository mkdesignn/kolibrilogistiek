<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('status')->unsigned()->default(1);
            $table->integer('createdBy')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('supplier_id');
            $table->string('number');

            $table->date('expected_at');
            $table->dateTime('received_at');
            $table->text('trackandtrace');

            $table->unique(['customer_id', 'number']);

        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('customer_id')->unsigned();
            $table->string('name');

            $table->unique(['customer_id', 'name']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchaseorders');
        Schema::drop('suppliers');
    }
}
