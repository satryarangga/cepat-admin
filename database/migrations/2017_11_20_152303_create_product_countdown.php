<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCountdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_countdown', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('duration')->comment('in seconds');
            $table->datetime('start_on')->nullable();
            $table->datetime('end_on')->nullable();
            $table->tinyInteger('status')->comment('0: not active, 1: active, 2: expired');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_countdown');
    }
}
