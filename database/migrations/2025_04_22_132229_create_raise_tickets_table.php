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
        Schema::create('raise_tickets', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title', 50)->nullable();
            $table->string('description')->nullable();
            $table->string('image', 50)->nullable();
            $table->text('signature_image')->nullable();
            $table->string('status', 20)->nullable()->default('Pending');
            $table->text('hold_reason')->nullable();
            $table->text('forward_reason')->nullable();
            $table->string('forward_by', 56)->nullable();
            $table->string('date', 20)->nullable();
            $table->string('assigned_to', 50)->nullable();
            $table->string('customer_id', 50)->nullable();
            $table->string('product_id', 50)->nullable();
            $table->string('unique_job_number', 50)->nullable();
            $table->string('progress_date', 20)->nullable();
            $table->string('complete_date', 20)->nullable();
            $table->string('parts', 56)->nullable();
            $table->string('assign_team_id', 50)->nullable();
            $table->text('tech_name')->nullable();
            $table->string('customer_status', 56)->default('pendding');
            $table->string('is_urgent', 11)->nullable();
            $table->text('title_close')->nullable();
            $table->text('close_description')->nullable();
            $table->text('close_image')->nullable();
            $table->string('authname', 100)->nullable();
            $table->text('auth_number')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('ic_canceled')->default(0);
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
        Schema::dropIfExists('raise_tickets');
    }
};
