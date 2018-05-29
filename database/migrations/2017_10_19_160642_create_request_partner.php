<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_partner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 150);
            $table->string('last_name', 150)->nullable();
            $table->string('email', 75);
            $table->string('handphone_number', 50);
            $table->string('homephone_number', 50)->nullable();
            $table->integer('province_id');
            $table->integer('city_id');
            $table->text('address');
            $table->text('desc')->nullable();
            $table->tinyInteger('status')->comment('0:pending, 1:Rejected, 2:Approved');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('request_partner');
    }
}
