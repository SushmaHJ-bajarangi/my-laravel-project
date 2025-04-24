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
        Schema::create('manufacturing', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('place')->nullable();
            $table->string('jobs')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('controller')->nullable();
            $table->string('controller_readiness_status')->nullable();
            $table->string('controller_readiness_date')->nullable();
            $table->text('comments')->nullable();
            $table->text('specification')->nullable();
            $table->text('issue')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('manufacturing');
    }
};
