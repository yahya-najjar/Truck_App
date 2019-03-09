<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->double('kilometrage')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->text('location')->nullable();
            
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
       Schema::dropIfExists('order_logs');
    }
}
