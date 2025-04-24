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
        Schema::create('crmproductions_dispatch', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('crmproductions_id');
            $table->string('dispatch_stage_lots_status_id')->nullable();
            $table->string('plandispatch_date')->nullable();
            $table->string('dispatch_status_id')->nullable();
            $table->string('go_down_dispatch_completion_date')->nullable();
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
        Schema::dropIfExists('crmproductions_dispatch');
    }
};
