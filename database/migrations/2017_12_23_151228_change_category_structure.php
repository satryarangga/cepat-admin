<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoryStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('category_parents');
        Schema::dropIfExists('category_childs');
        Schema::table('category_maps', function (Blueprint $table) {
            $table->dropColumn('category_parent_id');
            $table->dropColumn('category_child_id');
            $table->integer('category_id')->after('id');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->default(0);
            $table->string('name', 75);
            $table->string('url', 75);
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(0);
            $table->integer('created_by');
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
        Schema::table('category_maps', function (Blueprint $table) {
            $table->integer('category_parent_id');
            $table->integer('category_child_id');
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
}
