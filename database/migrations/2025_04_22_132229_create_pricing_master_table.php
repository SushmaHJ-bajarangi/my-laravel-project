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
        Schema::create('pricing_master', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('type')->nullable();
            $table->string('type_of_elevator')->nullable();
            $table->string('no_of_passengers')->nullable();
            $table->string('capacity_in_kg')->nullable();
            $table->string('no_of_stops')->nullable();
            $table->string('area_of_installation')->nullable();
            $table->string('basic_price')->nullable();
            $table->string('percentage')->nullable();
            $table->string('silver_care_amc_1_year')->nullable();
            $table->string('biennial_silver_care_2_year')->nullable();
            $table->string('triennial_silver_care_3_year')->nullable();
            $table->string('quinquennial_silver_care_5_year')->nullable();
            $table->string('silver_care_amc_gst')->nullable();
            $table->string('biennial_silver_care_gst')->nullable();
            $table->string('triennial_silver_care_gst')->nullable();
            $table->string('quinquennial_silver_care_gst')->nullable();
            $table->string('silver_care_amc_discounted')->nullable();
            $table->string('biennial_silver_care_discounted')->nullable();
            $table->string('triennial_silver_care_discounted')->nullable();
            $table->string('quinquennial_silver_care_discounted')->nullable();
            $table->string('gold_care_amc_1_year')->nullable();
            $table->string('biennial_gold_care_amc_2_year')->nullable();
            $table->string('triennial_gold_care_amc_3_year')->nullable();
            $table->string('quinquennial_gold_care_amc_5_year')->nullable();
            $table->string('gold_care_amc_gst')->nullable();
            $table->string('biennial_gold_care_amc_gst')->nullable();
            $table->string('triennial_gold_care_amc_gst')->nullable();
            $table->string('quinquennial_gold_care_amc_gst')->nullable();
            $table->string('gold_care_amc_discounted')->nullable();
            $table->string('biennial_gold_care_amc_discounted')->nullable();
            $table->string('triennial_gold_care_amc_discounted')->nullable();
            $table->string('quinquennial_gold_care_amc_discounted')->nullable();
            $table->string('platinum_care_amc_1_year')->nullable();
            $table->string('biennial_platinum_care_amc_2_year')->nullable();
            $table->string('triennial_platinum_care_amc_3_year')->nullable();
            $table->string('quinquennial_platinum_care_amc_5_year')->nullable();
            $table->string('platinum_care_amc_gst')->nullable();
            $table->string('biennial_platinum_care_gst')->nullable();
            $table->string('triennial_platinum_care_gst')->nullable();
            $table->string('quinquennial_platinum_care_gst')->nullable();
            $table->string('platinum_care_amc_discounted')->nullable();
            $table->string('biennial_platinum_care_amc_discounted')->nullable();
            $table->string('triennial_platinum_care_amc_discounted')->nullable();
            $table->string('quinquennial_platinum_care_amc_discounted')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_master');
    }
};
