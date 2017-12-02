<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('purchase_code', 50)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->comment('1:Cash Out, 2:Cash In')->default(1);
            $table->integer('amount');
            $table->integer('adjusted_by')->nullable();
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
        Schema::dropIfExists('wallet_log');
    }
}
