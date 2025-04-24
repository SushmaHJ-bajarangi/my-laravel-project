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
        Schema::create('manufacture_cop_lops', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->bigInteger('manufactures_id');
            $table->string('cop_lop')->nullable();
            $table->string('cop_lop_readiness_status');
            $table->date('cop_lop_readiness_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacture_cop_lops');
    }
};
