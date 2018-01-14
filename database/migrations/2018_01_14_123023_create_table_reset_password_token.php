<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResetPasswordToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reset_password_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('token', 75)->unique();
            $table->tinyInteger('status')->comment('0:not used, 1:used')->default(0);
            $table->timestamps();
            $table->datetime('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reset_password_tokens');
    }
}
