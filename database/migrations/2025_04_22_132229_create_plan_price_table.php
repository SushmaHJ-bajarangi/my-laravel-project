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
        Schema::create('plan_price', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('plan_id', 50)->nullable();
            $table->string('price', 50)->nullable();
            $table->string('no_of_floors_from', 50)->nullable();
            $table->string('no_of_floors_to', 50)->nullable();
            $table->string('passengers_capacity_from', 50)->nullable();
            $table->string('passengers_capacity_to', 50)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_price');
    }
};
