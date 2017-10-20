<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('code', 100)->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('discount_type')->comment('1"nominal, 2:percentage');
            $table->tinyInteger('transaction_type')->comment('1"single, 2:multiple transaction')->default(1);
            $table->integer('value');
            $table->integer('usage')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->comment('0:not active, 1:active')->default(1);
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
        Schema::dropIfExists('vouchers');
    }
}
