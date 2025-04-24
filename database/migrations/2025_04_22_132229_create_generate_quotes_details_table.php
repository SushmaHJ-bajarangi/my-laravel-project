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
        Schema::create('generate_quotes_details', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('quote_id', 50)->nullable();
            $table->string('plan', 20)->nullable();
            $table->integer('price')->nullable();
            $table->string('start_date', 56)->nullable();
            $table->string('end_date', 56)->nullable();
            $table->string('payment_type', 156)->nullable();
            $table->string('status', 56)->default('pending');
            $table->string('customer_id', 56);
            $table->string('payment_date', 56)->nullable();
            $table->string('final_amount', 56)->nullable();
            $table->text('payment_id')->nullable();
            $table->string('unique_job_number', 256);
            $table->string('amc_status', 56)->default('expired');
            $table->string('service', 11)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generate_quotes_details');
    }
};
