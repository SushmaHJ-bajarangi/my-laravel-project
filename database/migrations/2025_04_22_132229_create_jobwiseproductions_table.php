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
        Schema::create('jobwiseproductions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('place')->nullable();
            $table->string('job_no')->nullable();
            $table->string('crm_id')->nullable();
            $table->string('payment_received_manufacturing_date')->nullable();
            $table->string('crm_confirmation_date')->nullable();
            $table->text('customer_id')->nullable();
            $table->string('addressu')->nullable();
            $table->string('specifications')->nullable();
            $table->string('car_bracket')->nullable();
            $table->string('car_bracket_readiness_status')->nullable();
            $table->string('car_bracket_readiness_date')->nullable();
            $table->string('cwt_bracket')->nullable();
            $table->string('cwt_bracket_readiness_status')->nullable();
            $table->string('cwt_bracket_readiness_date')->nullable();
            $table->string('ld_opening')->nullable();
            $table->string('ld_finish')->nullable();
            $table->string('ld_frame_status')->nullable();
            $table->string('ld_frame_readiness_date')->nullable();
            $table->string('ld_status')->nullable();
            $table->string('ld_readiness_date')->nullable();
            $table->string('comments')->nullable();
            $table->string('machine_channel_type')->nullable();
            $table->string('machine_channel_readiness_status')->nullable();
            $table->string('machine_channel_readiness_date')->nullable();
            $table->string('machine')->nullable();
            $table->string('machine_readiness_status')->nullable();
            $table->string('machine_readiness_date')->nullable();
            $table->string('car_frame')->nullable();
            $table->string('car_frame_readiness_status')->nullable();
            $table->string('car_frame_readiness_date')->nullable();
            $table->string('cwt_frame')->nullable();
            $table->string('cwt_frame_readiness_status')->nullable();
            $table->string('cwt_frame_readiness_date')->nullable();
            $table->string('rope_available')->nullable();
            $table->string('osg_assy_available')->nullable();
            $table->string('comment_after_osg')->nullable();
            $table->string('cabin')->nullable();
            $table->string('cabin_readiness_status')->nullable();
            $table->string('cabin_readiness_date')->nullable();
            $table->string('controller')->nullable();
            $table->string('controller_readiness_status')->nullable();
            $table->string('controller_readiness_date')->nullable();
            $table->string('car_door_opening')->nullable();
            $table->string('car_door_finish')->nullable();
            $table->string('car_door_readiness_status')->nullable();
            $table->string('car_door_readiness_date')->nullable();
            $table->string('cop_lop')->nullable();
            $table->string('cop_lop_readiness_status')->nullable();
            $table->string('cop_lop_readiness_date')->nullable();
            $table->string('harness')->nullable();
            $table->string('harness_readiness_status')->nullable();
            $table->string('harness_readiness_date')->nullable();
            $table->string('commentscommentscomments')->nullable();
            $table->string('is_revised')->nullable();
            $table->string('full_dispatched_date1')->nullable();
            $table->string('car_bracket_available_status')->nullable();
            $table->string('car_bracket_available_date')->nullable();
            $table->string('car_bracket_dispatch_status')->nullable();
            $table->string('car_bracket_dispatch_date')->nullable();
            $table->string('cwt_bracket_available_status')->nullable();
            $table->string('cwt_bracket_available_date')->nullable();
            $table->string('cwt_bracket_dispatch_status')->nullable();
            $table->string('cwt_bracket_dispatch_date')->nullable();
            $table->string('ld_frame_received_date')->nullable();
            $table->string('ld_frame_dispatch_status')->nullable();
            $table->string('ld_frame_dispatch_date')->nullable();
            $table->string('ld_received_date')->nullable();
            $table->string('ld_dispatch_status')->nullable();
            $table->string('ld_dispatch_date')->nullable();
            $table->string('is_checkedbox')->nullable();
            $table->string('full_dispatched_date2')->nullable();
            $table->string('machine_channel_received_date')->nullable();
            $table->string('machine_channel_dispatch_status')->nullable();
            $table->string('machine_channel_dispatch_date')->nullable();
            $table->string('machine_available_date')->nullable();
            $table->string('machine_dispatch_status')->nullable();
            $table->string('machine_dispatch_date')->nullable();
            $table->string('car_frame_received_date')->nullable();
            $table->string('car_frame_dispatch_status')->nullable();
            $table->string('car_frame_dispatch_date')->nullable();
            $table->string('cwt_frame_received_date')->nullable();
            $table->string('cwt_frame_dispatch_status')->nullable();
            $table->text('cwt_frame_dispatch_date')->nullable();
            $table->text('rope_available_date')->nullable();
            $table->text('rope_dispatch_status')->nullable();
            $table->text('rope_dispatch_date')->nullable();
            $table->text('osg_assy_available_date')->nullable();
            $table->text('osg_assy_dispatch_status')->nullable();
            $table->text('osg_assy_dispatch_date')->nullable();
            $table->string('is_check')->nullable();
            $table->text('full_dispatched_date3')->nullable();
            $table->text('cabin_received_date')->nullable();
            $table->text('cabin_dispatch_status')->nullable();
            $table->string('cabin_dispatch_date')->nullable();
            $table->text('controller_available_date')->nullable();
            $table->text('controller_dispatch_status')->nullable();
            $table->text('controller_dispatch_date')->nullable();
            $table->text('car_door_received_date')->nullable();
            $table->text('car_door_dispatch_status')->nullable();
            $table->text('car_door__dispatch_date')->nullable();
            $table->text('cop_lop_received_date')->nullable();
            $table->text('cop_lop_dispatch_status')->nullable();
            $table->text('cop_lop__dispatch_date')->nullable();
            $table->text('harness_available_date')->nullable();
            $table->string('harness_dispatch_status')->nullable();
            $table->string('harness_dispatch_date')->nullable();
            $table->tinyInteger('created_from_crm')->default(0);
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
        Schema::dropIfExists('jobwiseproductions');
    }
};
