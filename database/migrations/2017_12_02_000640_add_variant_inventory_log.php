<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariantInventoryLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->integer('product_variant_id')->nullable()->after('product_id');
            $table->integer('order_id')->nullable()->after('user_id');
        });

        Schema::table('order_item', function (Blueprint $table) {
           $table->text('delivery_notes')->nullable()->after('notes'); 
           $table->text('shipping_notes')->nullable()->after('notes'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->dropColumn('product_variant_id');
            $table->dropColumn('order_id');
        });

        Schema::table('order_item', function (Blueprint $table) {
            $table->dropColumn('shipping_notes');
            $table->dropColumn('delivery_notes'); 
        });
    }
}
