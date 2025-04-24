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
        Schema::create('review', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('t_rating', 11)->default('NO');
            $table->string('ticket_id', 11)->nullable();
            $table->string('c_rating', 11)->default('NO');
            $table->string('t_star', 11)->nullable();
            $table->string('c_star', 11)->nullable();
            $table->string('rating_for', 11)->default('ticket');
            $table->text('comment_tec')->nullable();
            $table->text('comment_cus')->nullable();
            $table->string('customer_id', 56)->nullable();
            $table->integer('technician_id')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
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
        Schema::dropIfExists('review');
    }
};
