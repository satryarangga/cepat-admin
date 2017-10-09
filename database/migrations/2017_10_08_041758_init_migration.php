<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitMigration extends Migration
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
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 75);
            $table->string('password');
            $table->tinyInteger('gender')->comment('1:male, 2:female');
            $table->text('addr_street')->nullable();
            $table->string('addr_city_name', 75)->nullable();
            $table->integer('addr_city_id')->nullable();
            $table->string('addr_province_name', 75)->nullable();
            $table->integer('addr_province_id')->nullable();
            $table->string('addr_zipcode')->nullable();
            $table->string('phone', 35)->nullable();
            $table->date('birthdate')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:enabled, 2:blocked');
            $table->integer('wallet')->default(0);
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
