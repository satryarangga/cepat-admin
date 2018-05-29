<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable();
            $table->integer('product_id');
            $table->string('product_name', 100);
            $table->string('product_image', 255);
            $table->integer('variant_id');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('SKU', 75);
            $table->float('weight');
            $table->integer('price_ori_each');
            $table->integer('price_each');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->integer('partner_id');
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
        Schema::dropIfExists('shopping_cart');
    }
}
