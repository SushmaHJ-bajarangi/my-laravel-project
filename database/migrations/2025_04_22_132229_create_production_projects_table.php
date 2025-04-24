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
        Schema::create('production_projects', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('job_no');
            $table->string('customer_name');
            $table->string('project_name');
            $table->integer('crm_id');
            $table->string('payment_received_manufacturing_date', 1024);
            $table->string('crm_confirmation_date');
            $table->text('address');
            $table->text('specifications');
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
        Schema::dropIfExists('production_projects');
    }
};
