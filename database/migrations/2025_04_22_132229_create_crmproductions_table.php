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
        Schema::create('crmproductions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('crm_id')->nullable();
            $table->string('payment_received_manufacturing_date')->nullable();
            $table->string('crm_confirmation_date')->nullable();
            $table->string('job_no')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('addressu')->nullable();
            $table->string('contract_value')->nullable();
            $table->string('stage_of_materials_id')->nullable();
            $table->string('priority_id')->nullable();
            $table->string('requested_date_for_start_of_manufacturing_from_teknix_office')->nullable();
            $table->string('dispatch_request_date_from_teknix_office')->nullable();
            $table->string('dispatch_payments_status_id')->nullable();
            $table->string('amount_pending_for_dispatch')->nullable();
            $table->string('dispatch_comment')->nullable();
            $table->string('specifications')->nullable();
            $table->string('factory_commitment_date')->nullable();
            $table->integer('is_revised')->nullable();
            $table->string('manufacture_status_id')->nullable();
            $table->string('manufacture_stages_id')->nullable();
            $table->string('manufacture_completion_date')->nullable();
            $table->string('manufacture_comment')->nullable();
            $table->string('material_received_date_from_factory')->nullable();
            $table->integer('no_of_days_since_ready_for_dispatch')->nullable();
            $table->string('comments')->nullable();
            $table->string('created_from_crm');
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
        Schema::dropIfExists('crmproductions');
    }
};
