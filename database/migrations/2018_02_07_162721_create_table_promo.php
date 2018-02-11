<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_head', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('url', 100);
            $table->integer('duration');
            $table->integer('type')->comment('1:days, 2:hours, 3:minutes, 4:seconds');
            $table->string('banner')->nullable();
            $table->datetime('start_on');
            $table->datetime('end_on');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('status')->comment('0:not active, 1:active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('promo_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promo_id');
            $table->integer('product_id');
            $table->integer('promo_price');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_head');
        Schema::dropIfExists('promo_detail');
    }
}
