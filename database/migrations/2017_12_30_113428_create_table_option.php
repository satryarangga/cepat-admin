<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('url', 100);
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_option_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_option_id');
            $table->string('name', 255);
            $table->string('url', 100);
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_option_map_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('product_option_id');
            $table->integer('product_option_value_id');
            $table->timestamps();
        });

        Schema::create('product_option_map_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_option_id');
            $table->integer('category_id');
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
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('product_option_values');
        Schema::dropIfExists('product_option_map_category');
        Schema::dropIfExists('product_option_map_product');
    }
}
