<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDefaultColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->renameColumn('default', 'defaults');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->renameColumn('default', 'defaults');
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
            $table->renameColumn('defaults', 'default');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->renameColumn('defaults', 'default');
        });
    }
}
