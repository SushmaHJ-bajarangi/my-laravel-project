<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('customer_id', 20);
            $table->string('order_id', 20);
            $table->string('tracking_id', 20)->nullable();
            $table->string('bank_ref_no', 20)->nullable();
            $table->string('order_status', 50)->nullable();
            $table->string('failure_message', 1000)->nullable();
            $table->string('payment_mode', 50)->nullable();
            $table->string('card_name', 1000)->nullable();
            $table->string('status_code', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('amount', 20)->nullable();
            $table->string('billing_name', 200)->nullable();
            $table->string('billing_address', 1000)->nullable();
            $table->string('billing_city', 200)->nullable();
            $table->string('billing_state', 30)->nullable();
            $table->string('billing_zip', 10)->nullable();
            $table->string('billing_country', 30)->nullable();
            $table->string('billing_tel', 30)->nullable();
            $table->string('billing_email', 300)->nullable();
            $table->string('delivery_name', 500)->nullable();
            $table->string('delivery_address', 1000)->nullable();
            $table->string('delivery_city', 200)->nullable();
            $table->string('delivery_state', 200)->nullable();
            $table->string('delivery_zip', 20)->nullable();
            $table->string('delivery_country', 50)->nullable();
            $table->string('delivery_tel', 20)->nullable();
            $table->string('vault', 5)->nullable();
            $table->string('offer_type', 1000)->nullable();
            $table->string('offer_code', 1000)->nullable();
            $table->string('discount_value', 30)->nullable();
            $table->string('mer_amount', 50)->nullable();
            $table->string('eci_value', 50)->nullable();
            $table->string('retry', 100)->nullable();
            $table->string('response_code', 500)->nullable();
            $table->string('billing_notes', 1000)->nullable();
            $table->string('trans_date', 100)->nullable();
            $table->string('merchant_param1', 500)->nullable();
            $table->string('merchant_param2', 500)->nullable();
            $table->string('merchant_param3', 500)->nullable();
            $table->string('merchant_param4', 500)->nullable();
            $table->string('merchant_param5', 500)->nullable();
            $table->string('bin_country', 200)->nullable();
            $table->string('status_message', 500)->nullable();
            $table->string('transaction_for', 100)->nullable();
            $table->string('is_deleted', 12)->nullable()->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
