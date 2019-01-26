<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_name');
            $table->string('plate_num');
            $table->text('location')->nullable();
            $table->text('desc')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->double('distances')->nullable();
            $table->integer('capacity');
            $table->string('model');
            $table->integer('driver_phone');
            $table->integer('company_phone');
            $table->integer('status')->default(0);
            $table->integer('price_km');
            $table->integer('rating')->default(0);
            $table->text('expire_date')->nullable();
            $table->text('licence_date')->nullable();
            $table->text('image')->nullable();

            $table->integer('price_h');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('trucks');
    }
}
