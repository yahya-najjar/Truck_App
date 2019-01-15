<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('dob');
            $table->integer('gender');
            $table->integer('type');
            $table->integer('payment_type')->default(0);
            $table->integer('active')->default(0);
            $table->boolean('registeration_completed')->default(0);
            $table->string('code')->default(0);
            $table->string('Platform')->nullable();
            $table->string('FCM_Token')->nullable();

            $table->integer('truck_id')->unsigned()->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
