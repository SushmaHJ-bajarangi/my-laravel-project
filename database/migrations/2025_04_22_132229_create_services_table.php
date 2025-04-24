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
        Schema::create('services', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('customer_id', 50)->nullable();
            $table->string('unique_job_number', 50)->nullable();
            $table->string('customer_product_id', 50)->nullable();
            $table->string('date', 12)->nullable();
            $table->text('complete_service')->nullable();
            $table->string('status', 15)->nullable()->default('Pending');
            $table->string('image', 56)->nullable();
            $table->string('technician_id', 50)->nullable();
            $table->string('assign_team_id', 50)->nullable();
            $table->text('tech_name')->nullable();
            $table->string('zone', 20)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('service_type', 56)->default('normal');
            $table->text('signature_image')->nullable();
            $table->text('authname')->nullable();
            $table->text('auth_number')->nullable();
            $table->text('service_list')->nullable();
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
        Schema::dropIfExists('services');
    }
};
