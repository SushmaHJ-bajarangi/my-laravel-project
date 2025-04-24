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
        Schema::create('parts_request', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('customer_id', 50)->nullable();
            $table->string('unique_job_number', 50)->nullable();
            $table->string('amt', 50)->nullable();
            $table->string('ticket_id', 56)->nullable();
            $table->string('payment_type', 20)->nullable();
            $table->string('parts_id', 50)->nullable();
            $table->text('quantity')->nullable();
            $table->string('technician_user_id', 50)->nullable();
            $table->text('final_price');
            $table->string('payment_id', 256)->nullable();
            $table->string('payment_method', 256)->nullable();
            $table->string('date', 20)->nullable();
            $table->string('payment_date')->nullable();
            $table->string('status', 50)->nullable()->default('Not paid');
            $table->string('admin_status')->nullable()->default('Not paid');
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('parts_request');
    }
};
