<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorSizeName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('color_id')->change();
            $table->string('size_id')->change();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->string('color_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('color_id')->change();
            $table->integer('size_id')->change();
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->integer('color_id')->change();
        });
    }
}
