<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('online');
            $table->integer('truck_id')->unsigned()->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
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
        Schema::dropIfExists('truck_logs');
    }
}
