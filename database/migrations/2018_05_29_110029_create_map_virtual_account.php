<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapVirtualAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_xendit_va', function (Blueprint $table) {
            $table->increments('id');
            $table->string("xendit_id", 100);
            $table->integer('customer_id');
            $table->string('bank', 20);
            $table->string('va_number', 75);
            $table->datetime('va_expiration_date');
            $table->string('status', 50);
            $table->timestamps();
        });

        Schema::table('payment_method', function (Blueprint $table) {
            $table->tinyInteger('is_virtual_account')->comment('1:yes, no')->default(0)->after('use_paycode');
            $table->string('va_bank_code', 20)->after('use_paycode')->nullable();
        });

        Schema::table('order_payment', function (Blueprint $table) {
            $table->string('xendit_va_number', 75)->after('xendit_cc_charge_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_xendit_va');

        Schema::table('payment_method', function (Blueprint $table) {
            $table->dropColumn('is_virtual_account');
            $table->dropColumn('va_bank_code');
        });

        Schema::table('order_payment', function (Blueprint $table) {
            $table->dropColumn('xendit_va_number');
        });
    }
}
