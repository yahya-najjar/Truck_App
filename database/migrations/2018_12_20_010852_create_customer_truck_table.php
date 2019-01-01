<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTruckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_truck', function (Blueprint $table) {
            $table->increments('id');
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->text('date')->nullable();
            $table->text('note')->nullable();
            $table->double('hours')->default(0);
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')
                    ->on('customers')->onDelete('cascade');

            $table->integer('truck_id')->unsigned()->nullable();
            $table->foreign('truck_id')->references('id')
                    ->on('trucks')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_truck');
    }
}
