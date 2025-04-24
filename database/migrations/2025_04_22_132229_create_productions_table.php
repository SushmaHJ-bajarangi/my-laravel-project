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
        Schema::create('productions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('place');
            $table->string('manager')->nullable();
            $table->string('mnf_payment_date')->nullable();
            $table->string('crm_confirmation_date')->nullable();
            $table->string('job_no')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('contract_value')->nullable();
            $table->string('priority')->nullable();
            $table->string('mnf_confirmation_date')->nullable();
            $table->string('original_planned_dispatch_date')->nullable();
            $table->string('revised_planned_dispatch_date')->nullable();
            $table->string('dispatch_payment_status')->nullable();
            $table->string('pending_dispatch_amount_inr')->nullable();
            $table->string('manufacturing_status')->nullable();
            $table->string('dispatch_status')->nullable();
            $table->string('dispatch_stage_lot')->nullable();
            $table->text('comments')->nullable();
            $table->string('factory_commitment_date')->nullable();
            $table->string('revised_date_reason', 1025)->nullable();
            $table->string('revised_planed_dispatch', 1025)->nullable();
            $table->string('dispatch_date_reason_factory', 1025)->nullable();
            $table->string('revised_commitment_date_factory')->nullable();
            $table->string('material_readiness')->nullable();
            $table->string('completion_status')->nullable();
            $table->string('no_of_days')->nullable();
            $table->string('dispatch_date')->nullable();
            $table->text('specification')->nullable();
            $table->text('issue')->nullable();
            $table->text('address')->nullable();
            $table->integer('is_request')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productions');
    }
};
