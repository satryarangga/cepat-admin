<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_head', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purchase_code', 50);
            $table->date('date');
            $table->integer('customer_id');
            $table->integer('customer_email');
            $table->integer('total_purchase');
            $table->integer('shipping_cost');
            $table->integer('paycode');
            $table->integer('discount');
            $table->integer('credit_used');
            $table->integer('grand_total');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->text('address');
            $table->integer('province_id');
            $table->string('province_name', 150);
            $table->integer('city_id');
            $table->string('city_name', 150);
            $table->integer('postcode');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_discount', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('voucher_code', 150);
            $table->integer('voucher_id');
            $table->integer('voucher_value');
            $table->integer('voucher_name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('product_variant_id');
            $table->integer('product_price');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->integer('purchase_status')->comment('1. request, 2. confirm, 3. approved, 4. cancel, 5.refund')->default(1);
            $table->integer('shipping_status')->comment('0.Not Shipped , 1.Shipped,2.delivered,3.fail delivered,4.retur')->default(0);
            $table->string('resi', 50)->nullable();
            $table->text('notes')->nullable();
            $table->datetime('approved_time')->nullable();
            $table->datetime('shipping_time')->nullable();
            $table->datetime('delivery_time')->nullable();
            $table->integer('partner_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('payment_method_id');
            $table->string('confirmed_by', 100)->nullable();
            $table->string('confirmed_bank', 100)->nullable();
            $table->integer('confirmed_amount')->nullable();
            $table->integer('total_amount');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('order_item_id')->nullable();
            $table->string('desc', 75);
            $table->integer('done_by');
            $table->timestamps();
        });

        Schema::create('payment_method', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->text('desc')->nullable();
            $table->string('logo', 75)->nullable();
            $table->integer('minimum_payment')->nullable();
            $table->tinyInteger('confirm_type')->default(1)->comment('1:manual, 2:auto');
            $table->tinyInteger('status')->comment('0:not active, 1: active')->default(1);
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
        Schema::dropIfExists('order_head');
        Schema::dropIfExists('order_delivery');
        Schema::dropIfExists('order_discount');
        Schema::dropIfExists('order_payment');
        Schema::dropIfExists('order_log');
        Schema::dropIfExists('payment_method');
    }
}
