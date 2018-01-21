<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_log', function (Blueprint $table) {
            $table->string('source')->comment('front, back, cron')->default('front')->after('done_by');
        });

        Schema::table('order_delivery', function (Blueprint $table) {
            $table->renameColumn('order_item_id', 'partner_id');
            $table->integer('shipping_cost')->after('to_postcode');
            $table->string('shipping_method', 100)->after('to_postcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_log', function (Blueprint $table) {
            $table->dropColumn('source');
        });

        Schema::table('order_delivery', function (Blueprint $table) {
            $table->renameColumn('partner_id', 'order_item_id');
            $table->dropColumn('shipping_cost');
            $table->dropColumn('shipping_method');
        });
    }
}
