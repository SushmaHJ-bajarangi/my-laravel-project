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
        Schema::create('production_mnf_stages', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('prod_id')->nullable();
            $table->integer('ms_id')->nullable();
            $table->string('production_date')->nullable();
            $table->string('readiness_date')->nullable();
            $table->string('status')->nullable();
            $table->string('mf_by')->nullable();
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
        Schema::dropIfExists('production_mnf_stages');
    }
};
