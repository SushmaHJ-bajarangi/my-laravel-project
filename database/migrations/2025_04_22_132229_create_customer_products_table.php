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
        Schema::create('customer_products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('customer_id');
            $table->string('area')->nullable();
            $table->integer('noofstops')->nullable();
            $table->text('model_id');
            $table->string('number_of_floors')->nullable();
            $table->string('passenger_capacity')->nullable();
            $table->text('distance');
            $table->text('unique_job_number');
            $table->string('warranty_start_date', 56)->nullable();
            $table->string('warranty_end_date', 56)->nullable();
            $table->string('ordered_date', 20)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('side_status', 30)->nullable();
            $table->string('no_of_services', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('zone', 20)->nullable();
            $table->string('amc_value', 250)->nullable();
            $table->string('amc_status', 10)->nullable();
            $table->string('amc_start_date', 56)->nullable();
            $table->string('amc_end_date', 56)->nullable();
            $table->string('project_name', 50)->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('customer_products');
    }
};
