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
        Schema::create('punches', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('ticket_id');
            $table->integer('technician_id');
            $table->string('type', 10)->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('distance')->nullable();
            $table->string('date', 20)->nullable();
            $table->string('time', 20)->nullable();
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
        Schema::dropIfExists('punches');
    }
};
