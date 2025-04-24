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
        Schema::create('parts_details', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('part_id')->nullable();
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->string('gst', 12)->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
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
        Schema::dropIfExists('parts_details');
    }
};
