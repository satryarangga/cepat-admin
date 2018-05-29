<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_method', function (Blueprint $table) {
            $table->string('code', 100)->after('name');
        });

        Schema::table('order_payment', function (Blueprint $table) {
            $table->text('xendit_cc_charge_response')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_method', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('order_payment', function (Blueprint $table) {
            $table->dropColumn('xendit_cc_charge_response');
        });
    }
}
