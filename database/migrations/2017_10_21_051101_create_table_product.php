<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_parents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->string('url', 75);
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_childs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('name', 75);
            $table->string('url', 75);
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->string('hexa', 20);
            $table->string('url', 50);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('size', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->string('url', 50);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->integer('original_price')->default(0);
            $table->integer('discount_price')->default(0);
            $table->integer('modal_price')->default(0);
            $table->float('weight');
            $table->text('description')->nullable();
            $table->integer('status')->comment('0:disabled, 1:enabled')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('color_id');
            $table->string('url', 200);
            $table->tinyInteger('default')->default(0)->comment('primary picture 0:no, 1:yes');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('color_id');
            $table->integer('size_id');
            $table->string('SKU', 75);
            $table->tinyInteger('default')->default(0)->comment('primary variant 0:no, 1:yes');
            $table->integer('qty_order')->default(0);
            $table->integer('qty_warehouse')->default(0);
            $table->integer('max_order_qty')->comment('maximum qty when add to cart');
            $table->integer('status')->comment('0:disabled, 1:enabled')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_parent_id');
            $table->integer('category_child_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('purchase_code', 100);
            $table->integer('user_id');
            $table->string('SKU');
            $table->integer('qty');
            $table->integer('type')->comment('1. Inventory In, 2.Inventory Out, 3. Correction In, 4. Correction Out');
            $table->text('description')->nullable();
            $table->integer('source')->comment('1:front end, 2:admin, 3:cron');
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
        Schema::dropIfExists('category_parents');
        Schema::dropIfExists('category_childs');
        Schema::dropIfExists('category_maps');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('size');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('inventory_logs');
    }
}
