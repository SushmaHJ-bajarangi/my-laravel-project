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
        Schema::create('generate_quotes', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('customer_id')->nullable();
            $table->string('customer_job_id', 50)->nullable();
            $table->string('status', 20)->nullable();
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
        Schema::dropIfExists('generate_quotes');
    }
};
