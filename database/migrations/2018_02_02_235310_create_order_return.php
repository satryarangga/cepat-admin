<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_item_id');
            $table->integer('product_id');
            $table->integer('product_variant_id');
            $table->text('reason')->nullable();
            $table->tinyInteger('status')->comment('0:processed, 1:received');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_return');
    }
}
