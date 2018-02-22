<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentMethodPaycode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_method', function (Blueprint $table) {
            $table->tinyInteger('use_paycode')->comment('0:no, 1:yes')->default(1)->after('confirm_type');
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
            $table->dropColumn('use_paycode');
        });
    }
}
