<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePartners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_name', 150);
            $table->string('owner_name', 150);
            $table->string('email', 150);
            $table->string('handphone_number', 150);
            $table->string('homephone_number', 150)->nullable();
            $table->integer('province_id');
            $table->integer('city_id');
            $table->text('address');
            $table->string('postcode', 25);
            $table->string('bank_acc_no', 100)->nullable();
            $table->string('bank_acc_name', 100)->nullable();
            $table->tinyInteger('status')->comment('1:active, 0:blocked')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('request_partner', function (Blueprint $table) {
            $table->string('store_name', 150)->after('last_name');
            $table->string('postcode', 25)->after('address');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('partner_id')->after('user_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');

        Schema::table('request_partner', function (Blueprint $table) {
            $table->dropColumn('store_name');
            $table->dropColumn('postcode');
        });

        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn('partner_id');
        });
    }
}
