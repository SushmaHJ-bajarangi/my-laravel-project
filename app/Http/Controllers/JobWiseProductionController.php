<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\JobWiseProduction;
use App\Models\Production;
use App\Models\customers;
use App\Models\StageOfMaterial;
use App\Models\DispatchPaymentStatus;
use App\Models\Priority;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;
use App\Models\ProductionSom;
use App\Models\ProductionMnfStage;
use App\Models\CrmProduction;
use App\Models\Crm;
use App\Models\CarBracket;
use App\Models\CwtBracket;
use App\Models\LdOpening;
use App\Models\LdFinish;
use App\Models\MachineChannel;
use App\Models\Machine;
use App\Models\CarFrame;
use App\Models\CwtFrame;
use App\Models\RopeAvailable;
use App\Models\OSGAssyAvailable;
use App\Models\Controller;
use App\Models\CarDoorOpening;
use App\Models\CopAndLop;
use App\Models\Harness;
use App\Models\CarBracketReadinessStatus;
use App\Models\DispatchStatus;
use App\Models\DispatchStageLotStatus;
use App\Models\CrmProductionDispatch;
use App\Http\Requests\CreatecustomersRequest;
use App\Repositories\customersRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Imports\JobWiseProductionImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JobWiseProductionExport;

class JobWiseProductionController extends AppBaseController
{
    public function index()
    {
        $data = JobWiseProduction::get();
        return view('job_wise_production.index')->with('data',$data);
//        return $data;
    }

    public function create()
    {
        $customer = customers::where('is_deleted', 0)->get();
        $carbracket = CarBracket::where('is_deleted', 0)->get();
        $cwtbracket = CwtBracket::where('is_deleted', 0)->get();
        $ldopening = LdOpening::where('is_deleted', 0)->get();
        $ldfinish = LdFinish::where('is_deleted', 0)->get();
        $machinechannel =MachineChannel::where('is_deleted', 0)->get();
        $machine = Machine::where('is_deleted', 0)->get();
        $carframe =  CarFrame::where('is_deleted', 0)->get();
        $cwtframe =  CwtFrame::where('is_deleted', 0)->get();
        $ropeavailable =RopeAvailable::where('is_deleted', 0)->get();
        $osgassyavailable =OSGAssyAvailable::where('is_deleted', 0)->get();
        $controller=Controller::where('is_deleted', 0)->get();
        $cardooropening=CarDoorOpening::where('is_deleted', 0)->get();
        $copandlop=CopAndLop::where('is_deleted', 0)->get();
        $harness=Harness::where('is_deleted', 0)->get();
        $readinessstatus = CarBracketReadinessStatus::where('is_deleted', 0)->get();
        $jobno = CrmProduction::get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_production = ManufactureStatus::where('is_deleted', 0)->get();
        $crm = Crm::where('is_deleted', 0)->get();
        $dispatch_payments_status=DispatchPaymentStatus::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $dispatch_stage_lots_status = DispatchStageLotStatus::where('is_deleted', 0)->get();

        return view('job_wise_production.create',
             compact(
            'customer', 'stage_of_material','priority','manufacture_production','manufacture_stages',
            'manufacture_status','crm','dispatch_payments_status','dispatch_status','dispatch_stage_lots_status',
            'jobno','carbracket', 'readinessstatus','cwtbracket','ldopening',
            'ldfinish','machinechannel','machine','carframe','cwtframe',
            'ropeavailable','osgassyavailable','controller','cardooropening',
             'copandlop','harness'));
     }

    public function getJobDetails($jobNoId)
    {
        $job = CrmProduction::where('job_no',$jobNoId)->first();

        if ($job) {
            $customer = customers::find($job->customer_id);
            $crm = Crm::find($job->crm_id);

            return response()->json([
                'success' => true,
                'crm_id' => $crm ? $crm->id : null,
                'crm_name' => $crm ? $crm->name : null,
                'customer_id' => $job->customer_id ?? null,
                'customer_name' => $job->customer_id ?? null,
                'payment_received_manufacturing_date' => $job->payment_received_manufacturing_date,
                'crm_confirmation_date' => $job->crm_confirmation_date,
                'addressu' => $job->addressu,
                'specifications' => $job->specifications
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ]);
        }
    }

    public function store(Request $request)
    {
//        return $request;
//        $rules = [];
//
//        if ($request->has('is_revised') && $request->is_revised == 'on') {
//            $rules['full_dispatched_date1'] = 'required';
//        }
//
//        if ($request->has('is_checkedbox') && $request->is_checkedbox == 'on') {
//            $rules['full_dispatched_date2'] = 'required';
//        }
//
//        if ($request->has('is_check') && $request->is_check == 'on') {
//            $rules['full_dispatched_date3'] = 'required';
//        }
//
//        if (!empty($rules)) {
//            $validatedData = $request->validate($rules);
//        }
//
//        $rules = [];
//
//        $currentStep = $request->input('current_step'); // Get the current step
//
//        if (in_array($currentStep, [5, 6, 7])) { // Apply validation only for steps 5, 6, and 7
//            if ($currentStep == 5 && $request->has('is_revised') && $request->is_revised == 'on') {
//                $rules['full_dispatched_date1'] = 'required';
//            }
//
//            if ($currentStep == 6 && $request->has('is_checkedbox') && $request->is_checkedbox == 'on') {
//                $rules['full_dispatched_date2'] = 'required';
//            }
//
//            if ($currentStep == 7 && $request->has('is_check') && $request->is_check == 'on') {
//                $rules['full_dispatched_date3'] = 'required';
//            }
//        }
//
//        if (!empty($rules)) {
//            $validatedData = $request->validate($rules);
//        }
//
//        $validatedData = $request->validate([
//                'place' => 'required|string|max:255',
//                'job_no' => 'required|string|max:255',
//                'crm_id' => 'required|string|max:255',
//                'payment_received_manufacturing_date' => 'required|date',
//                'crm_confirmation_date' =>  'required|date',
//                'customer_id' => 'required|string|max:255',
//                'addressu' => 'required',
//                'specifications' => 'required'
//          ]);
        $rules = [
            'place' => 'required|string|max:255',
            'job_no' =>  'required|string|max:255|unique:jobwiseproductions,job_no',
            'crm_id' => 'required|string|max:255',
            'payment_received_manufacturing_date' => 'required|date',
            'crm_confirmation_date' =>  'required|date',
            'customer_id' => 'required|string|max:255',
            'addressu' => 'required',
            'specifications' => 'required'
        ];

        $currentStep = $request->input('current_step');

        if (in_array($currentStep, [5, 6, 7])) {

            if ($currentStep == 5 && $request->has('is_revised') && $request->is_revised == 'on') {
                $rules['full_dispatched_date1'] = 'required';
            }

            if ($currentStep == 6 && $request->has('is_checkedbox') && $request->is_checkedbox == 'on') {
                $rules['full_dispatched_date2'] = 'required';
            }

            if ($currentStep == 7 && $request->has('is_check') && $request->is_check == 'on') {
                $rules['full_dispatched_date3'] = 'required';
            }

        }

        $validatedData = $request->validate($rules);

        if (\App\Models\JobWiseProduction::where('job_no', $request->job_no)->exists()) {
            return redirect()->back()->withErrors(['job_no' => 'The job number already exists.'])->withInput();
        }

        $jobwiseproduction = new JobWiseProduction;
        $jobwiseproduction->place = $request->place;
        $jobwiseproduction->job_no = $request->job_no;
        $jobwiseproduction->crm_id = $request->crm_id;
        $jobwiseproduction->payment_received_manufacturing_date = $request->payment_received_manufacturing_date;
        $jobwiseproduction->crm_confirmation_date = $request->crm_confirmation_date;
        $jobwiseproduction->customer_id = $request->customer_id;
        $jobwiseproduction->addressu = $request->addressu;
        $jobwiseproduction->specifications = $request->specifications;
        $jobwiseproduction->car_bracket = $request->car_bracket;
        $jobwiseproduction->car_bracket_readiness_status = $request->car_bracket_readiness_status;
        $jobwiseproduction->car_bracket_readiness_date = $request->car_bracket_readiness_date;
        $jobwiseproduction->cwt_bracket = $request->cwt_bracket;
        $jobwiseproduction->cwt_bracket_readiness_status = $request->cwt_bracket_readiness_status;
        $jobwiseproduction->cwt_bracket_readiness_date = $request->cwt_bracket_readiness_date;
        $jobwiseproduction->ld_opening = $request->ld_opening;
        $jobwiseproduction->ld_finish = $request->ld_finish;
        $jobwiseproduction->ld_frame_status = $request->ld_frame_status;
        $jobwiseproduction->ld_frame_readiness_date = $request->ld_frame_readiness_date;
        $jobwiseproduction->ld_status = $request->ld_status;
        $jobwiseproduction->ld_readiness_date = $request->ld_readiness_date;
        $jobwiseproduction->comments = $request->comments;
        $jobwiseproduction->machine_channel_type = $request->machine_channel_type;
        $jobwiseproduction->machine_channel_readiness_status = $request->machine_channel_readiness_status;
        $jobwiseproduction->machine_channel_readiness_date = $request->machine_channel_readiness_date;
        $jobwiseproduction->machine = $request->machine;
        $jobwiseproduction->machine_readiness_status = $request->machine_readiness_status;
        $jobwiseproduction->machine_readiness_date = $request->machine_readiness_date;
        $jobwiseproduction->car_frame = $request->car_frame;
        $jobwiseproduction->car_frame_readiness_status = $request->car_frame_readiness_status;
        $jobwiseproduction->car_frame_readiness_date = $request->car_frame_readiness_date;
        $jobwiseproduction->cwt_frame = $request->cwt_frame;
        $jobwiseproduction->cwt_frame_readiness_status = $request->cwt_frame_readiness_status;
        $jobwiseproduction->cwt_frame_readiness_date = $request->cwt_frame_readiness_date;
        $jobwiseproduction->rope_available = $request->rope_available;
        $jobwiseproduction->osg_assy_available = $request->osg_assy_available;
        $jobwiseproduction->comment_after_osg = $request->comment_after_osg;
        $jobwiseproduction->cabin = $request->cabin;
        $jobwiseproduction->cabin_readiness_status = $request->cabin_readiness_status;
        $jobwiseproduction->cabin_readiness_date = $request->cabin_readiness_date;
        $jobwiseproduction->controller = $request->controller;
        $jobwiseproduction->controller_readiness_status = $request->controller_readiness_status;
        $jobwiseproduction->controller_readiness_date = $request->controller_readiness_date;
        $jobwiseproduction->car_door_opening = $request->car_door_opening;
        $jobwiseproduction->car_door_finish = $request->car_door_finish;
        $jobwiseproduction->car_door_readiness_status = $request->car_door_readiness_status;
        $jobwiseproduction->car_door_readiness_date = $request->car_door_readiness_date;
        $jobwiseproduction->cop_lop = $request->cop_lop;
        $jobwiseproduction->cop_lop_readiness_status = $request->cop_lop_readiness_status;
        $jobwiseproduction->cop_lop_readiness_date = $request->cop_lop_readiness_date;
        $jobwiseproduction->harness = $request->harness;
        $jobwiseproduction->harness_readiness_status = $request->harness_readiness_status;
        $jobwiseproduction->harness_readiness_date = $request->harness_readiness_date;
        $jobwiseproduction->commentscommentscomments = $request->commentscommentscomments;
        $jobwiseproduction->is_revised = $request->is_revised ? 1: 0;
        $jobwiseproduction->full_dispatched_date1 = $request->full_dispatched_date1;
        $jobwiseproduction->car_bracket_available_status = $request->car_bracket_available_status;
        $jobwiseproduction->car_bracket_available_date = $request->car_bracket_available_date;
        $jobwiseproduction->car_bracket_dispatch_status = $request->car_bracket_dispatch_status;
        $jobwiseproduction->car_bracket_dispatch_date = $request->car_bracket_dispatch_date;
        $jobwiseproduction->cwt_bracket_available_status = $request->cwt_bracket_available_status;
        $jobwiseproduction->cwt_bracket_available_date = $request->cwt_bracket_available_date;
        $jobwiseproduction->cwt_bracket_dispatch_status = $request->cwt_bracket_dispatch_status;
        $jobwiseproduction->cwt_bracket_dispatch_date = $request->cwt_bracket_dispatch_date;
        $jobwiseproduction->ld_frame_received_date = $request->ld_frame_received_date;
        $jobwiseproduction->ld_frame_dispatch_status = $request->ld_frame_dispatch_status;
        $jobwiseproduction->ld_frame_dispatch_date = $request->ld_frame_dispatch_date;
        $jobwiseproduction->ld_received_date = $request->ld_received_date;
        $jobwiseproduction->ld_dispatch_status = $request->ld_dispatch_status;
        $jobwiseproduction->ld_dispatch_date = $request->ld_dispatch_date;
        $jobwiseproduction->is_checkedbox = $request->is_checkedbox ? 1: 0;
        $jobwiseproduction->full_dispatched_date2 = $request->full_dispatched_date2;
        $jobwiseproduction->machine_channel_received_date = $request->machine_channel_received_date;
        $jobwiseproduction->machine_channel_dispatch_status = $request->machine_channel_dispatch_status;
        $jobwiseproduction->machine_channel_dispatch_date = $request->machine_channel_dispatch_date;
        $jobwiseproduction->machine_available_date = $request->machine_available_date;
        $jobwiseproduction->machine_dispatch_status = $request->machine_dispatch_status;
        $jobwiseproduction->machine_dispatch_date = $request->machine_dispatch_date;
        $jobwiseproduction->car_frame_received_date = $request->car_frame_received_date;
        $jobwiseproduction->car_frame_dispatch_status = $request->car_frame_dispatch_status;
        $jobwiseproduction->car_frame_dispatch_date = $request->car_frame_dispatch_date;
        $jobwiseproduction->cwt_frame_received_date = $request->cwt_frame_received_date;
        $jobwiseproduction->cwt_frame_dispatch_status = $request->cwt_frame_dispatch_status;
        $jobwiseproduction->cwt_frame_dispatch_date = $request->cwt_frame_dispatch_date;
        $jobwiseproduction->rope_available_date = $request->rope_available_date;
        $jobwiseproduction->rope_dispatch_status = $request->rope_dispatch_status;
        $jobwiseproduction->rope_dispatch_date = $request->rope_dispatch_date;
        $jobwiseproduction->osg_assy_available_date = $request->osg_assy_available_date;
        $jobwiseproduction->osg_assy_dispatch_status = $request->osg_assy_dispatch_status;
        $jobwiseproduction->osg_assy_dispatch_date = $request->osg_assy_dispatch_date;
        $jobwiseproduction->is_check = $request->is_check ? 1: 0;
        $jobwiseproduction->full_dispatched_date3 = $request->full_dispatched_date3;
        $jobwiseproduction->cabin_received_date = $request->cabin_received_date;
        $jobwiseproduction->cabin_dispatch_status = $request->cabin_dispatch_status;
        $jobwiseproduction->cabin_dispatch_date = $request->cabin_dispatch_date;
        $jobwiseproduction->controller_available_date = $request->controller_available_date;
        $jobwiseproduction->controller_dispatch_status = $request->controller_dispatch_status;
        $jobwiseproduction->controller_dispatch_date = $request->controller_dispatch_date;
        $jobwiseproduction->car_door_received_date = $request->car_door_received_date;
        $jobwiseproduction->car_door_dispatch_status = $request->car_door_dispatch_status;
        $jobwiseproduction->car_door__dispatch_date = $request->car_door__dispatch_date;
        $jobwiseproduction->cop_lop_received_date = $request->cop_lop_received_date;
        $jobwiseproduction->cop_lop_dispatch_status = $request->cop_lop_dispatch_status;
        $jobwiseproduction->cop_lop__dispatch_date = $request->cop_lop__dispatch_date;
        $jobwiseproduction->harness_available_date = $request->harness_available_date;
        $jobwiseproduction->harness_dispatch_status = $request->harness_dispatch_status;
        $jobwiseproduction->harness_dispatch_date = $request->harness_dispatch_date;

        $jobwiseproduction->save();

        Flash::success('Saved Successfully.');
        return redirect(url('job_wise_production'));
    }

    public function edit($id)
    {
        $customer = customers::where('is_deleted', 0)->get();
        $carbracket = CarBracket::where('is_deleted', 0)->get();
        $cwtbracket = CwtBracket::where('is_deleted', 0)->get();
        $ldopening = LdOpening::where('is_deleted', 0)->get();
        $ldfinish = LdFinish::where('is_deleted', 0)->get();
        $machinechannel = MachineChannel::where('is_deleted', 0)->get();
        $machine = Machine::where('is_deleted', 0)->get();
        $carframe = CarFrame::where('is_deleted', 0)->get();
        $cwtframe = CwtFrame::where('is_deleted', 0)->get();
        $ropeavailable = RopeAvailable::where('is_deleted', 0)->get();
        $osgassyavailable = OSGAssyAvailable::where('is_deleted', 0)->get();
        $controller = Controller::where('is_deleted', 0)->get();
        $cardooropening = CarDoorOpening::where('is_deleted', 0)->get();
        $copandlop = CopAndLop::where('is_deleted', 0)->get();
        $harness = Harness::where('is_deleted', 0)->get();
        $readinessstatus = CarBracketReadinessStatus::where('is_deleted', 0)->get();
        $jobno = CrmProduction::get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_production = ManufactureStatus::where('is_deleted', 0)->get();
        $crm = Crm::where('is_deleted', 0)->get();
        $dispatch_payments_status = DispatchPaymentStatus::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $dispatch_stage_lots_status = DispatchStageLotStatus::where('is_deleted', 0)->get();

        $data = JobWiseProduction::whereId($id)->first();
        if (empty($data)) {
            Flash::error('Not Found.');
            return redirect(url('job_wise_production'));
        }

        return view('job_wise_production.edit',  compact(
            'data', 'customer', 'stage_of_material', 'priority', 'manufacture_production', 'manufacture_stages',
            'manufacture_status', 'crm', 'dispatch_payments_status', 'dispatch_status', 'dispatch_stage_lots_status',
            'jobno', 'carbracket', 'readinessstatus', 'cwtbracket', 'ldopening', 'ldfinish', 'machinechannel', 'machine',
            'carframe', 'cwtframe', 'ropeavailable', 'osgassyavailable', 'controller', 'cardooropening', 'copandlop',
            'harness'
        ));
    }

    public function update($id,Request $request)
    {
        if(isset($request->is_revised) && $request->is_revised == 'on')
        {
            $validatedData = $request->validate([
                'full_dispatched_date1' => 'required',
            ]);
        }

        if(isset($request->is_checkedbox) && $request->is_checkedbox == 'on')
        {
            $validatedData = $request->validate([
                'full_dispatched_date2' => 'required',
            ]);
        }

        if(isset($request->is_check) && $request->is_check == 'on')
        {
            $validatedData = $request->validate([
                'full_dispatched_date3' => 'required',
            ]);
        }

        $jobwiseproduction = JobWiseProduction::whereId($id)->first();

        if (empty($jobwiseproduction)) {
            Flash::error('Not Found');
            return redirect(url('job_wise_production'));
        }
        $jobData = [

            'place' => $request->place,
            'job_no' => $request->job_no,
            'crm_id' => $request->crm_id,
            'payment_received_manufacturing_date' => $request->payment_received_manufacturing_date,
            'crm_confirmation_date' => $request->crm_confirmation_date,
            'customer_id' => $request->customer_id,
            'addressu' => $request->addressu,
            'specifications' => $request->specifications,
            'car_bracket' => $request->car_bracket,
            'car_bracket_readiness_status' => $request->car_bracket_readiness_status,
            'car_bracket_readiness_date' => $request->car_bracket_readiness_date,
            'cwt_bracket' => $request->cwt_bracket,
            'cwt_bracket_readiness_status' => $request->cwt_bracket_readiness_status,
            'cwt_bracket_readiness_date' => $request->cwt_bracket_readiness_date,
            'ld_opening' => $request->ld_opening,
            'ld_finish' => $request->ld_finish,
            'ld_frame_status' => $request->ld_frame_status,
            'ld_frame_readiness_date' => $request->ld_frame_readiness_date,
            'ld_status' => $request->ld_status,
            'ld_readiness_date' => $request->ld_readiness_date,
            'comments' => $request->comments,
            'machine_channel_type' => $request->machine_channel_type,
            'machine_channel_readiness_status' => $request->machine_channel_readiness_status,
            'machine_channel_readiness_date' => $request->machine_channel_readiness_date,
            'machine' => $request->machine,
            'machine_readiness_status' => $request->machine_readiness_status,
            'machine_readiness_date' => $request->machine_readiness_date,
            'car_frame' => $request->car_frame,
            'car_frame_readiness_status' => $request->car_frame_readiness_status,
            'car_frame_readiness_date' => $request->car_frame_readiness_date,
            'cwt_frame' => $request->cwt_frame,
            'cwt_frame_readiness_status' => $request->cwt_frame_readiness_status,
            'cwt_frame_readiness_date' => $request->cwt_frame_readiness_date,
            'rope_available' => $request->rope_available,
            'osg_assy_available' => $request->osg_assy_available,
            'comment_after_osg' => $request->comment_after_osg,
            'cabin' => $request->cabin,
            'cabin_readiness_status' => $request->cabin_readiness_status,
            'cabin_readiness_date' => $request->cabin_readiness_date,
            'controller' => $request->controller,
            'controller_readiness_status' => $request->controller_readiness_status,
            'controller_readiness_date' => $request->controller_readiness_date,
            'car_door_opening' => $request->car_door_opening,
            'car_door_finish' => $request->car_door_finish,
            'car_door_readiness_status' => $request->car_door_readiness_status,
            'car_door_readiness_date' => $request->car_door_readiness_date,
            'cop_lop' => $request->cop_lop,
            'cop_lop_readiness_status' => $request->cop_lop_readiness_status,
            'cop_lop_readiness_date' => $request->cop_lop_readiness_date,
            'harness' => $request->harness,
            'harness_readiness_status' => $request->harness_readiness_status,
            'harness_readiness_date' => $request->harness_readiness_date,
            'commentscommentscomments' => $request->commentscommentscomments,
            'is_revised' => $request->is_revised ? 1 : 0,
            'full_dispatched_date1' => $request->full_dispatched_date1,
            'car_bracket_available_status' => $request->car_bracket_available_status,
            'car_bracket_available_date' => $request->car_bracket_available_date,
            'car_bracket_dispatch_status' => $request->car_bracket_dispatch_status,
            'car_bracket_dispatch_date' => $request->car_bracket_dispatch_date,
            'cwt_bracket_available_status' => $request->cwt_bracket_available_status,
            'cwt_bracket_available_date' => $request->cwt_bracket_available_date,
            'cwt_bracket_dispatch_status' => $request->cwt_bracket_dispatch_status,
            'cwt_bracket_dispatch_date' => $request->cwt_bracket_dispatch_date,
            'ld_frame_received_date' => $request->ld_frame_received_date,
            'ld_frame_dispatch_status' => $request->ld_frame_dispatch_status,
            'ld_frame_dispatch_date' => $request->ld_frame_dispatch_date,
            'ld_received_date' => $request->ld_received_date,
            'ld_dispatch_status' => $request->ld_dispatch_status,
            'ld_dispatch_date' => $request->ld_dispatch_date,
            'is_checkedbox' => $request->is_checkedbox ? 1 : 0,
            'full_dispatched_date2' => $request->full_dispatched_date2,
            'machine_channel_received_date' => $request->machine_channel_received_date,
            'machine_channel_dispatch_status' => $request->machine_channel_dispatch_status,
            'machine_channel_dispatch_date' => $request->machine_channel_dispatch_date,
            'machine_available_date' => $request->machine_available_date,
            'machine_dispatch_status' => $request->machine_dispatch_status,
            'machine_dispatch_date' => $request->machine_dispatch_date,
            'car_frame_received_date' => $request->car_frame_received_date,
            'car_frame_dispatch_status' => $request->car_frame_dispatch_status,
            'car_frame_dispatch_date' => $request->car_frame_dispatch_date,
            'cwt_frame_received_date' => $request->cwt_frame_received_date,
            'cwt_frame_dispatch_status' => $request->cwt_frame_dispatch_status,
            'cwt_frame_dispatch_date' => $request->cwt_frame_dispatch_date,
            'rope_available_date' => $request->rope_available_date,
            'rope_dispatch_status' => $request->rope_dispatch_status,
            'rope_dispatch_date' => $request->rope_dispatch_date,
            'osg_assy_available_date' => $request->osg_assy_available_date,
            'osg_assy_dispatch_status' => $request->osg_assy_dispatch_status,
            'osg_assy_dispatch_date' => $request->osg_assy_dispatch_date,
            'is_check' => $request->is_check ? 1 : 0,
            'full_dispatched_date3' => $request->full_dispatched_date3,
            'cabin_received_date' => $request->cabin_received_date,
            'cabin_dispatch_status' => $request->cabin_dispatch_status,
            'cabin_dispatch_date' => $request->cabin_dispatch_date,
            'controller_available_date' => $request->controller_available_date,
            'controller_dispatch_status' => $request->controller_dispatch_status,
            'controller_dispatch_date' => $request->controller_dispatch_date,
            'car_door_received_date' => $request->car_door_received_date,
            'car_door_dispatch_status' => $request->car_door_dispatch_status,
            'car_door__dispatch_date' => $request->car_door__dispatch_date,
            'cop_lop_received_date' => $request->cop_lop_received_date,
            'cop_lop_dispatch_status' => $request->cop_lop_dispatch_status,
            'cop_lop__dispatch_date' => $request->cop_lop__dispatch_date,
            'harness_available_date' => $request->harness_available_date,
            'harness_dispatch_status' => $request->harness_dispatch_status,
            'harness_dispatch_date' => $request->harness_dispatch_date,
        ];
        $isJobExist = \App\Models\JobWiseProduction::where('job_no', $request->job_no)->first();
        if (empty($isJobExist)) {
            JobWiseProduction::create($jobData);
        } else {
            $isJobExist->update($jobData);
        }

        $jobwiseproduction->save();

        Flash::success('updated Successfully.');

        return redirect(url('job_wise_production'));
    }

    public function delete($id)
    {
        $data = JobWiseProduction::whereId($id)->first();
        if(empty($data))
        {
            Flash::success("Not found");
            return redirect(url('job_wise_production'));
        }
        JobWiseProduction::whereId($id)->delete();
        Flash::success('job wise deleted successfully');
        return redirect(url('job_wise_production'));
    }

    public function importjobwiseproduction(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls'
        ]);

        if ($request->hasFile('import_file')) {
            $file = $request->file('import_file');

            $rows = Excel::toArray(new JobWiseProductionImport, $file)[0];

            if (empty($rows) || count($rows) === 0) {
                Flash::error('File is empty.');
                return redirect()->back();
            }

            $header = $rows[0];
            if (empty($header) || count(array_filter($header)) === 0) {
                Flash::error('File header is missing or empty.');
                return redirect()->back();
            }

            if (isset($header[0]) && $header[0] !== 'Place') {
                Flash::error('The first header column must be "Place".');
                return redirect()->back();
            }

            $requiredColumns = [
                "Place",
                "Job No",
                "CRM",
                "Payment Received for Manufactruing Date",
                "Crm Confirmation Date",
                "Customer Name",
                "Address Details",
                "Specifications",
                "Car Bracket",
                "Car Bracket Readiness Status",
                "Car Bracket Radiness Date",
                "Cwt Bracket",
                "Cwt Bracket Radiness Status",
                "Cwt Bracket Radiness Date",
                "LD Opening",
                "LD Finish",
                "LD Frame Status",
                "LD Frame Readiness Date",
                "LD Status",
                "LD Radiness Date",
                "Comments",
                "Machine Channel Type",
                "Machine Channel Readiness Status",
                "Machine channel Radiness Date",
                "Machine",
                "Machine Radiness Status",
                "Machine Radiness Date",
                "Car Frame",
                "Car Frame Readiness Status",
                "Car Frame Radiness Date",
                "Cwt Frame",
                "Cwt Frame Radiness Status",
                "Cwt Frame Radiness Date",
                "Rope Available",
                "OSG Assy Available",
                "Comments",
                "Cabin",
                "Cabin Readiness Status",
                "Cabin Radiness Date",
                "Controller",
                "Controller Readiness Status",
                "Controller Radiness Date",
                "Car Door Opening",
                "Car Door Finish",
                "Car Door Status",
                "Car Door Radiness Date",
                "COP & LOP",
                "COP & LOP Status",
                "COP & LOP Radiness Date",
                "Harness",
                "Harness Readiness Status",
                "Harness Radiness Date",
                "Comments",
                "Full Dispatched",
                "Full Dispatched Date",
                "Car Bracket Available Status",
                "Car Bracket Available Date",
                "Car Bracket Dispatch Status",
                "Car Bracket Dispatch Date",
                "Cwt Bracket Available Status",
                "Cwt Bracket Available Date",
                "Cwt Bracket Dispatch Status",
                "Cwt Bracket Dispatch Date",
                "LD Frame Received Date",
                "LD Frame Dispatch Status",
                "LD Frame Dispatch Date",
                "LD Received Date",
                "LD Dispatch Status",
                "LD Dispatch Date",
                "Full Dispatched",
                "Full Dispatched Date",
                "Machine Channel Received Date",
                "Machine Channel Dispatch Status",
                "Machine Channel Dispatch Date",
                "Machine Available Date",
                "Machine Dispatch Status",
                "Machine Dispatch Date",
                "Car Frame Received Date",
                "Car Frame Dispatch Status",
                "Car Frame Dispatch Date",
                "Cwt Frame Received Date:",
                "Cwt Frame Dispatch Status",
                "Cwt Frame Dispatch Date",
                "Rope Available Date",
                "Rope Dispatch Status",
                "Rope Dispatch Date",
                "OSG Assy Available Date",
                "OSG Assy Dispatch Status",
                "OSG Assy Dispatch Date",
                "Full Dispatched",
                "Full Dispatched Date",
                "Cabin Received Date",
                "Cabin Dispatch Status",
                "Cabin Dispatch Date",
                "Controller Available Date",
                "Controller Dispatch Status",
                "Controller Dispatch Date",
                "Car Door Received Date",
                "Car Door Dispatch Status",
                "Car Door Dispatch Date",
                "Cop And Lop Received Date",
                "Cop And Lop Dispatch Status",
                "Cop And Lop Dispatch Date",
                "Harness Available Date",
                "Harness Dispatch Status",
                "Harness Dispatch Date"
            ];

            foreach ($requiredColumns as $column) {
                if (!in_array($column, $header)) {
                    Flash::error("Missing required column: $column.");
                    return redirect()->back();
                }
            }

            if(count($rows) > 0) {
                foreach ($rows as $key => $row) {
                    if ($key > 0) {

                        $crm = Crm::where('name', $row[2])->first();
                        if(empty($crm) && !empty($row[2])){
                            $crm = Crm::create([
                                'name' => $row[2]
                            ]);
                            $crmId = $crm->id;
                        }
                        else{
                            $crmId = $crm->id ?? null;
                        }

                        $customer = customers::where('name', $row[5])->first();
                        $customerId = $customer ? $customer->id : null;

                        $car_bracket = CarBracket::where('name', $row[8])->first();
                        if(empty($car_bracket) && !empty($row[8])){
                            $car_bracket = CarBracket::create([
                                'name' => $row[8]
                            ]);
                            $car_bracketId = $car_bracket->id;
                        }
                        else{
                            $car_bracketId = $car_bracket->id ?? null;
                        }

                        $car_bracket_readiness_status = CarBracketReadinessStatus::where('title', $row[9])->first();
                        if(empty($car_bracket_readiness_status) && !empty($row[9])){
                            $car_bracket_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[9]
                            ]);
                            $car_bracket_readiness_statusId = $car_bracket_readiness_status->id;
                        }
                        else{
                            $car_bracket_readiness_statusId = $car_bracket_readiness_status->id ?? null;
                        }

                        $cwt_bracket = CwtBracket::where('name', $row[11])->first();
                        if(empty($cwt_bracket) && !empty($row[11])){
                            $cwt_bracket = CwtBracket::create([
                                'name' => $row[11]
                            ]);
                            $cwt_bracketId = $cwt_bracket->id;
                        }
                        else{
                            $cwt_bracketId = $cwt_bracket->id ?? null;
                        }

                        $cwt_bracket_readiness_status = CarBracketReadinessStatus::where('title', $row[12])->first();
                        if(empty($cwt_bracket_readiness_status) && !empty($row[12])){
                            $cwt_bracket_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[12]
                            ]);
                            $cwt_bracket_readiness_statusId = $cwt_bracket_readiness_status->id;
                        }
                        else{
                            $cwt_bracket_readiness_statusId = $cwt_bracket_readiness_status->id ?? null;
                        }

                        $ld_opening = LdOpening::where('name', $row[14])->first();
                        if(empty($ld_opening) && !empty($row[14])){
                            $ld_opening = LdOpening::create([
                                'name' => $row[14]
                            ]);
                            $ld_openingId = $ld_opening->id;
                        }
                        else{
                            $ld_openingId = $ld_opening->id ?? null;
                        }

                        $ld_finish = LdFinish::where('name', $row[15])->first();
                        if(empty($ld_finish) && !empty($row[15])){
                            $ld_finish = LdFinish::create([
                                'name' => $row[15]
                            ]);
                            $ld_finishId = $ld_finish->id;
                        }
                        else{
                            $ld_finishId = $ld_finish->id ?? null;
                        }

                        $ld_frame_status = CarBracketReadinessStatus::where('title', $row[16])->first();
                        if(empty($ld_frame_status) && !empty($row[16])){
                            $ld_frame_status = CarBracketReadinessStatus::create([
                                'title' => $row[16]
                            ]);
                            $ld_frame_statusId = $ld_frame_status->id;
                        }
                        else{
                            $ld_frame_statusId = $ld_frame_status->id ?? null;
                        }

                        $ld_status = CarBracketReadinessStatus::where('title', $row[18])->first();
                        if(empty($ld_status) && !empty($row[18])){
                            $ld_status = CarBracketReadinessStatus::create([
                                'title' => $row[18]
                            ]);
                            $ld_statusId = $ld_status->id;
                        }
                        else{
                            $ld_statusId = $ld_status->id ?? null;
                        }

                        $machine_channel_type = MachineChannel::where('name', $row[21])->first();
                        if(empty($machine_channel_type) && !empty($row[21])){
                            $machine_channel_type = MachineChannel::create([
                                'name' => $row[21]
                            ]);
                            $machine_channel_typeId = $machine_channel_type->id;
                        }
                        else{
                            $machine_channel_typeId = $machine_channel_type->id ?? null;
                        }

                        $machine_channel_readiness_status = CarBracketReadinessStatus::where('title', $row[22])->first();
                        if(empty($machine_channel_readiness_status) && !empty($row[22])){
                            $machine_channel_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[22]
                            ]);
                            $machine_channel_readiness_statusId = $machine_channel_readiness_status->id;
                        }
                        else{
                            $machine_channel_readiness_statusId = $machine_channel_readiness_status->id ?? null;
                        }

                        $machine = Machine::where('name', $row[24])->first();
                        if(empty($machine) && !empty($row[24])){
                            $machine = Machine::create([
                                'name' => $row[24]
                            ]);
                            $machineId = $machine->id;
                        }
                        else{
                            $machineId = $machine->id ?? null;
                        }

                        $machine_readiness_status = CarBracketReadinessStatus::where('title', $row[25])->first();
                        if(empty($machine_readiness_status) && !empty($row[25])){
                            $machine_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[25]
                            ]);
                            $machine_readiness_statusId = $machine_readiness_status->id;
                        }
                        else{
                            $machine_readiness_statusId = $machine_readiness_status->id ?? null;
                        }

                        $car_frame = CarFrame::where('name', $row[27])->first();
                        if(empty($car_frame) && !empty($row[27])){
                            $car_frame = CarFrame::create([
                                'name' => $row[27]
                            ]);
                            $car_frameId = $car_frame->id;
                        }
                        else{
                            $car_frameId = $car_frame->id ?? null;
                        }

                        $car_frame_readiness_status = CarBracketReadinessStatus::where('title', $row[28])->first();
                        if(empty($car_frame_readiness_status) && !empty($row[28])){
                            $car_frame_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[28]
                            ]);
                            $car_frame_readiness_statusId = $car_frame_readiness_status->id;
                        }
                        else{
                            $car_frame_readiness_statusId = $car_frame_readiness_status->id ?? null;
                        }

                        $cwt_frame = CwtFrame::where('name', $row[30])->first();
                        if(empty($cwt_frame) && !empty($row[30])){
                            $cwt_frame = CwtFrame::create([
                                'name' => $row[30]
                            ]);
                            $cwt_frameId = $cwt_frame->id;
                        }
                        else{
                            $cwt_frameId = $cwt_frame->id ?? null;
                        }

                        $cwt_frame_readiness_status = CarBracketReadinessStatus::where('title', $row[31])->first();
                        if(empty($cwt_frame_readiness_status) && !empty($row[31])){
                            $cwt_frame_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[31]
                            ]);
                            $cwt_frame_readiness_statusId = $cwt_frame_readiness_status->id;
                        }
                        else{
                            $cwt_frame_readiness_statusId = $cwt_frame_readiness_status->id ?? null;
                        }

                        $rope_available = RopeAvailable::where('name', $row[33])->first();
                        if(empty($rope_available) && !empty($row[33])){
                            $rope_available = RopeAvailable::create([
                                'name' => $row[33]
                            ]);
                            $rope_availableId = $rope_available->id;
                        }
                        else{
                            $rope_availableId = $rope_available->id ?? null;
                        }

                        $osg_assy_available = OSGAssyAvailable::where('name', $row[34])->first();
                        if(empty($osg_assy_available) && !empty($row[34])){
                            $osg_assy_available = OSGAssyAvailable::create([
                                'name' => $row[34]
                            ]);
                            $osg_assy_availableId = $osg_assy_available->id;
                        }
                        else{
                            $osg_assy_availableId = $osg_assy_available->id ?? null;
                        }

                        $cabin = LdFinish::where('name', $row[36])->first();
                        if(empty($cabin) && !empty($row[36])){
                            $cabin = LdFinish::create([
                                'name' => $row[36]
                            ]);
                            $cabinId = $cabin->id;
                        }
                        else{
                            $cabinId = $cabin->id ?? null;
                        }

                        $cabin_readiness_status = CarBracketReadinessStatus::where('title', $row[37])->first();
                        if(empty($cabin_readiness_status) && !empty($row[37])){
                            $cabin_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[37]
                            ]);
                            $cabin_readiness_statusId = $cabin_readiness_status->id;
                        }
                        else{
                            $cabin_readiness_statusId = $cabin_readiness_status->id ?? null;
                        }

                        $controller = Controller::where('name', $row[39])->first();
                        if(empty($controller) && !empty($row[39])){
                            $controller = Controller::create([
                                'name' => $row[39]
                            ]);
                            $controllerId = $controller->id;
                        }
                        else{
                            $controllerId = $controller->id ?? null;
                        }

                        $controller_readiness_status = CarBracketReadinessStatus::where('title', $row[40])->first();
                        if(empty($controller_readiness_status) && !empty($row[40])){
                            $controller_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[40]
                            ]);
                            $controller_readiness_statusId = $controller_readiness_status->id;
                        }
                        else{
                            $controller_readiness_statusId = $controller_readiness_status->id ?? null;
                        }

                        $car_door_opening = CarDoorOpening::where('name', $row[42])->first();
                        if(empty($car_door_opening) && !empty($row[42])){
                            $car_door_opening = CarDoorOpening::create([
                                'name' => $row[42]
                            ]);
                            $car_door_openingId = $car_door_opening->id;
                        }
                        else{
                            $car_door_openingId = $car_door_opening->id ?? null;
                        }

                        $car_door_finish = LdFinish::where('name', $row[43])->first();
                        if(empty($car_door_finish) && !empty($row[43])){
                            $car_door_finish = LdFinish::create([
                                'name' => $row[43]
                            ]);
                            $car_door_finishId = $car_door_finish->id;
                        }
                        else{
                            $car_door_finishId = $car_door_finish->id ?? null;
                        }

                        $car_door_readiness_status = CarBracketReadinessStatus::where('title', $row[44])->first();
                        if(empty($car_door_readiness_status) && !empty($row[44])){
                            $car_door_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[44]
                            ]);
                            $car_door_readiness_statusId = $car_door_readiness_status->id;
                        }
                        else{
                            $car_door_readiness_statusId = $car_door_readiness_status->id ?? null;
                        }

                        $cop_lop = CopAndLop::where('name', $row[46])->first();
                        if(empty($cop_lop) && !empty($row[46])){
                            $cop_lop = CopAndLop::create([
                                'name' => $row[46]
                            ]);
                            $cop_lopId = $cop_lop->id;
                        }
                        else{
                            $cop_lopId = $cop_lop->id ?? null;
                        }

                        $cop_lop_readiness_status = CarBracketReadinessStatus::where('title', $row[47])->first();
                        if(empty($cop_lop_readiness_status) && !empty($row[47])){
                            $cop_lop_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[47]
                            ]);
                            $cop_lop_readiness_statusId = $cop_lop_readiness_status->id;
                        }
                        else{
                            $cop_lop_readiness_statusId = $cop_lop_readiness_status->id ?? null;
                        }

                        $harness = Harness::where('name', $row[49])->first();
                        if(empty($harness) && !empty($row[49])){
                            $harness = Harness::create([
                                'name' => $row[49]
                            ]);
                            $harnessId = $harness->id;
                        }
                        else{
                            $harnessId = $harness->id ?? null;
                        }

                        $harness_readiness_status = CarBracketReadinessStatus::where('title', $row[50])->first();
                        if(empty($harness_readiness_status) && !empty($row[50])){
                            $harness_readiness_status = CarBracketReadinessStatus::create([
                                'title' => $row[50]
                            ]);
                            $harness_readiness_statusId = $harness_readiness_status->id;
                        }
                        else{
                            $harness_readiness_statusId = $harness_readiness_status->id ?? null;
                        }

                        $car_bracket_available_status = CarBracketReadinessStatus::where('title', $row[55])->first();
                        if(empty($car_bracket_available_status) && !empty($row[55])){
                            $car_bracket_available_status = CarBracketReadinessStatus::create([
                                'title' => $row[55]
                            ]);
                            $car_bracket_available_statusId = $car_bracket_available_status->id;
                        }
                        else{
                            $car_bracket_available_statusId = $car_bracket_available_status->id ?? null;
                        }

                        $car_bracket_dispatch_status = CarBracketReadinessStatus::where('title', $row[57])->first();
                        if(empty($car_bracket_dispatch_status) && !empty($row[57])){
                            $car_bracket_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[57]
                            ]);
                            $car_bracket_dispatch_statusId = $car_bracket_dispatch_status->id;
                        }
                        else{
                            $car_bracket_dispatch_statusId = $car_bracket_dispatch_status->id ?? null;
                        }

                        $cwt_bracket_available_status = CarBracketReadinessStatus::where('title', $row[59])->first();
                        if(empty($cwt_bracket_available_status) && !empty($row[59])){
                            $cwt_bracket_available_status = CarBracketReadinessStatus::create([
                                'title' => $row[59]
                            ]);
                            $cwt_bracket_available_statusId = $cwt_bracket_available_status->id;
                        }
                        else{
                            $cwt_bracket_available_statusId = $cwt_bracket_available_status->id ?? null;
                        }

                        $cwt_bracket_dispatch_status = CarBracketReadinessStatus::where('title', $row[61])->first();
                        if(empty($cwt_bracket_dispatch_status) && !empty($row[61])){
                            $cwt_bracket_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[61]
                            ]);
                            $cwt_bracket_dispatch_statusId = $cwt_bracket_dispatch_status->id;
                        }
                        else{
                            $cwt_bracket_dispatch_statusId = $cwt_bracket_dispatch_status->id ?? null;
                        }


                        $ld_frame_dispatch_status = CarBracketReadinessStatus::where('title', $row[64])->first();
                        if(empty($ld_frame_dispatch_status) && !empty($row[64])){
                            $ld_frame_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[64]
                            ]);
                            $ld_frame_dispatch_statusId = $ld_frame_dispatch_status->id;
                        }
                        else{
                            $ld_frame_dispatch_statusId = $ld_frame_dispatch_status->id ?? null;
                        }

                        $ld_dispatch_status = CarBracketReadinessStatus::where('title', $row[67])->first();
                        if(empty($ld_dispatch_status) && !empty($row[67])){
                            $ld_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[67]
                            ]);
                            $ld_dispatch_statusId = $ld_dispatch_status->id;
                        }
                        else{
                            $ld_dispatch_statusId = $ld_dispatch_status->id ?? null;
                        }

                        $machine_channel_dispatch_status = CarBracketReadinessStatus::where('title', $row[72])->first();
                        if(empty($machine_channel_dispatch_status) && !empty($row[72])){
                            $machine_channel_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[72]
                            ]);
                            $machine_channel_dispatch_statusId = $machine_channel_dispatch_status->id;
                        }
                        else{
                            $machine_channel_dispatch_statusId = $machine_channel_dispatch_status->id ?? null;
                        }

                        $machine_dispatch_status = CarBracketReadinessStatus::where('title', $row[75])->first();
                        if(empty($machine_dispatch_status) && !empty($row[75])){
                            $machine_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[75]
                            ]);
                            $machine_dispatch_statusId = $machine_dispatch_status->id;
                        }
                        else{
                            $machine_dispatch_statusId = $machine_dispatch_status->id ?? null;
                        }

                        $car_frame_dispatch_status = CarBracketReadinessStatus::where('title', $row[78])->first();
                        if(empty($car_frame_dispatch_status) && !empty($row[78])){
                            $car_frame_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[78]
                            ]);
                            $car_frame_dispatch_statusId = $car_frame_dispatch_status->id;
                        }
                        else{
                            $car_frame_dispatch_statusId = $car_frame_dispatch_status->id ?? null;
                        }

                        $cwt_frame_dispatch_status = CarBracketReadinessStatus::where('title', $row[81])->first();
                        if(empty($cwt_frame_dispatch_status) && !empty($row[81])){
                            $cwt_frame_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[81]
                            ]);
                            $cwt_frame_dispatch_statusId = $cwt_frame_dispatch_status->id;
                        }
                        else{
                            $cwt_frame_dispatch_statusId = $cwt_frame_dispatch_status->id ?? null;
                        }

                        $rope_dispatch_status = CarBracketReadinessStatus::where('title', $row[84])->first();
                        if(empty($rope_dispatch_status) && !empty($row[84])){
                            $rope_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[84]
                            ]);
                            $rope_dispatch_statusId = $rope_dispatch_status->id;
                        }
                        else{
                            $rope_dispatch_statusId = $rope_dispatch_status->id ?? null;
                        }

                        $osg_assy_dispatch_status = CarBracketReadinessStatus::where('title', $row[87])->first();
                        if(empty($osg_assy_dispatch_status) && !empty($row[87])){
                            $osg_assy_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[87]
                            ]);
                            $osg_assy_dispatch_statusId = $osg_assy_dispatch_status->id;
                        }
                        else{
                            $osg_assy_dispatch_statusId = $osg_assy_dispatch_status->id ?? null;
                        }

                        $cabin_dispatch_status = CarBracketReadinessStatus::where('title', $row[92])->first();
                        if(empty($cabin_dispatch_status) && !empty($row[92])){
                            $cabin_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[92]
                            ]);
                            $cabin_dispatch_statusId = $cabin_dispatch_status->id;
                        }
                        else {
                            $cabin_dispatch_statusId = $cabin_dispatch_status->id ?? null;
                        }


                        $controller_dispatch_status = CarBracketReadinessStatus::where('title', $row[95])->first();
                        if(empty($controller_dispatch_status) && !empty($row[95])){
                            $controller_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[95]
                            ]);
                            $controller_dispatch_statusId = $controller_dispatch_status->id;
                        }
                        else {
                            $controller_dispatch_statusId = $controller_dispatch_status->id ?? null;
                        }

                        $car_door_dispatch_status = CarBracketReadinessStatus::where('title', $row[98])->first();
                        if(empty($car_door_dispatch_status) && !empty($row[98])){
                            $car_door_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[98]
                            ]);
                            $car_door_dispatch_statusId = $car_door_dispatch_status->id;
                        }
                        else {
                            $car_door_dispatch_statusId = $car_door_dispatch_status->id ?? null;
                        }

                        $cop_lop_dispatch_status = CarBracketReadinessStatus::where('title', $row[101])->first();
                        if(empty($cop_lop_dispatch_status) && !empty($row[101])){
                            $cop_lop_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[101]
                            ]);
                            $cop_lop_dispatch_statusId = $cop_lop_dispatch_status->id;
                        }
                        else {
                            $cop_lop_dispatch_statusId = $cop_lop_dispatch_status->id ?? null;
                        }

                        $harness_dispatch_status = CarBracketReadinessStatus::where('title', $row[104])->first();
                        if(empty($harness_dispatch_status) && !empty($row[104])){
                            $harness_dispatch_status = CarBracketReadinessStatus::create([
                                'title' => $row[104]
                            ]);
                            $harness_dispatch_statusId = $harness_dispatch_status->id;
                        }
                        else {
                            $harness_dispatch_statusId = $harness_dispatch_status->id ?? null;
                        }

                        $existingjobwiseProduction = JobWiseProduction::where('job_no', $row[1])->first();
                        if ($existingjobwiseProduction) {
                            JobWiseProduction::where('job_no', $row[1])->update([
                                'place' => $row[0],
                                'job_no' => $row[1],
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' =>
                                    !empty($row[3])
                                        ? (is_numeric($row[3])
                                        ? $this->excelDateToDate($row[3])
                                        : date('Y-m-d', strtotime($row[3])))
                                        : null,
                                'crm_confirmation_date' =>
                                    !empty($row[4])
                                        ? (is_numeric($row[4])
                                        ? $this->excelDateToDate($row[4])
                                        : date('Y-m-d', strtotime($row[4])))
                                        : null,
                                'customer_id' => $row[5],
                                'addressu' => $row[6],
                                'specifications' => $row[7],

                                'car_bracket' => $car_bracketId,
                                'car_bracket_readiness_status' => $car_bracket_readiness_statusId,
                                'car_bracket_readiness_date' =>
                                    !empty($row[10])
                                        ? (is_numeric($row[10])
                                        ? $this->excelDateToDate($row[10])
                                        : date('Y-m-d', strtotime($row[10])))
                                        : null,
                                'cwt_bracket' => $cwt_bracketId,
                                'cwt_bracket_readiness_status' => $cwt_bracket_readiness_statusId,
                                'cwt_bracket_readiness_date' =>
                                    !empty($row[13])
                                        ? (is_numeric($row[13])
                                        ? $this->excelDateToDate($row[13])
                                        : date('Y-m-d', strtotime($row[13])))
                                        : null,
                                'ld_opening' => $ld_openingId,
                                'ld_finish' => $ld_finishId,
                                'ld_frame_status' => $ld_frame_statusId,
                                'ld_frame_readiness_date' =>
                                    !empty($row[17])
                                        ? (is_numeric($row[17])
                                        ? $this->excelDateToDate($row[17])
                                        : date('Y-m-d', strtotime($row[17])))
                                        : null,
                                'ld_status' => $ld_statusId,
                                'ld_readiness_date' =>
                                    !empty($row[19])
                                        ? (is_numeric($row[19])
                                        ? $this->excelDateToDate($row[19])
                                        : date('Y-m-d', strtotime($row[19])))
                                        : null,
                                'comments' => $row[20],

                                'machine_channel_type' => $machine_channel_typeId,
                                'machine_channel_readiness_status' => $machine_channel_readiness_statusId,
                                'machine_channel_readiness_date' =>
                                    !empty($row[23])
                                        ? (is_numeric($row[23])
                                        ? $this->excelDateToDate($row[23])
                                        : date('Y-m-d', strtotime($row[23])))
                                        : null,
                                'machine' => $machineId,
                                'machine_readiness_status' => $machine_readiness_statusId,
                                'machine_readiness_date' =>
                                    !empty($row[26])
                                        ? (is_numeric($row[26])
                                        ? $this->excelDateToDate($row[26])
                                        : date('Y-m-d', strtotime($row[26])))
                                        : null,
                                'car_frame' => $car_frameId,
                                'car_frame_readiness_status' => $car_frame_readiness_statusId,
                                'car_frame_readiness_date' =>
                                    !empty($row[29])
                                        ? (is_numeric($row[29])
                                        ? $this->excelDateToDate($row[29])
                                        : date('Y-m-d', strtotime($row[29])))
                                        : null,
                                'cwt_frame' => $cwt_frameId,
                                'cwt_frame_readiness_status' => $cwt_frame_readiness_statusId,
                                'cwt_frame_readiness_date' =>
                                    !empty($row[32])
                                        ? (is_numeric($row[32])
                                        ? $this->excelDateToDate($row[32])
                                        : date('Y-m-d', strtotime($row[32])))
                                        : null,
                                'rope_available' => $rope_availableId,
                                'osg_assy_available' => $osg_assy_availableId,
                                'comment_after_osg' => $row[35],

                                'cabin' => $cabinId,
                                'cabin_readiness_status' => $cabin_readiness_statusId,
                                'cabin_readiness_date' =>
                                    !empty($row[38])
                                        ? (is_numeric($row[38])
                                        ? $this->excelDateToDate($row[38])
                                        : date('Y-m-d', strtotime($row[38])))
                                        : null,
                                'controller' => $controllerId,
                                'controller_readiness_status' => $controller_readiness_statusId,
                                'controller_readiness_date' =>
                                    !empty($row[41])
                                        ? (is_numeric($row[41])
                                        ? $this->excelDateToDate($row[41])
                                        : date('Y-m-d', strtotime($row[41])))
                                        : null,
                                'car_door_opening' => $car_door_openingId,
                                'car_door_finish' => $car_door_finishId,
                                'car_door_readiness_status' => $car_door_readiness_statusId,
                                'car_door_readiness_date' =>
                                    !empty($row[45])
                                        ? (is_numeric($row[45])
                                        ? $this->excelDateToDate($row[45])
                                        : date('Y-m-d', strtotime($row[45])))
                                        : null,
                                'cop_lop' => $cop_lopId,
                                'cop_lop_readiness_status' => $cop_lop_readiness_statusId,
                                'cop_lop_readiness_date' =>
                                    !empty($row[48])
                                        ? (is_numeric($row[48])
                                        ? $this->excelDateToDate($row[48])
                                        : date('Y-m-d', strtotime($row[48])))
                                        : null,
                                'harness' => $harnessId,
                                'harness_readiness_status' => $harness_readiness_statusId,
                                'harness_readiness_date' =>
                                    !empty($row[51])
                                        ? (is_numeric($row[51])
                                        ? $this->excelDateToDate($row[51])
                                        : date('Y-m-d', strtotime($row[51])))
                                        : null,
                                'commentscommentscomments' => $row[52],

                                'is_revised' => $row[53],
                                'full_dispatched_date1' =>
                                    !empty($row[54])
                                        ? (is_numeric($row[54])
                                        ? $this->excelDateToDate($row[54])
                                        : date('Y-m-d', strtotime($row[54])))
                                        : null,
                                'car_bracket_available_status' => $car_bracket_available_statusId,
                                'car_bracket_available_date' =>
                                    !empty($row[56])
                                        ? (is_numeric($row[56])
                                        ? $this->excelDateToDate($row[56])
                                        : date('Y-m-d', strtotime($row[56])))
                                        : null,
                                'car_bracket_dispatch_status' => $car_bracket_dispatch_statusId,
                                'car_bracket_dispatch_date' =>
                                    !empty($row[58])
                                        ? (is_numeric($row[58])
                                        ? $this->excelDateToDate($row[58])
                                        : date('Y-m-d', strtotime($row[58])))
                                        : null,
                                'cwt_bracket_available_status' => $cwt_bracket_available_statusId,
                                'cwt_bracket_available_date' =>
                                    !empty($row[60])
                                        ? (is_numeric($row[60])
                                        ? $this->excelDateToDate($row[60])
                                        : date('Y-m-d', strtotime($row[60])))
                                        : null,
                                'cwt_bracket_dispatch_status' => $cwt_bracket_dispatch_statusId,
                                'cwt_bracket_dispatch_date' =>
                                    !empty($row[62])
                                        ? (is_numeric($row[62])
                                        ? $this->excelDateToDate($row[62])
                                        : date('Y-m-d', strtotime($row[62])))
                                        : null,
                                'ld_frame_received_date' =>
                                    !empty($row[63])
                                        ? (is_numeric($row[63])
                                        ? $this->excelDateToDate($row[63])
                                        : date('Y-m-d', strtotime($row[63])))
                                        : null,
                                'ld_frame_dispatch_status' => $ld_frame_dispatch_statusId,
                                'ld_frame_dispatch_date' =>
                                    !empty($row[65])
                                        ? (is_numeric($row[65])
                                        ? $this->excelDateToDate($row[65])
                                        : date('Y-m-d', strtotime($row[65])))
                                        : null,
                                'ld_received_date' =>
                                    !empty($row[66])
                                        ? (is_numeric($row[66])
                                        ? $this->excelDateToDate($row[66])
                                        : date('Y-m-d', strtotime($row[66])))
                                        : null,
                                'ld_dispatch_status' => $ld_dispatch_statusId,
                                'ld_dispatch_date' =>
                                    !empty($row[68])
                                        ? (is_numeric($row[68])
                                        ? $this->excelDateToDate($row[68])
                                        : date('Y-m-d', strtotime($row[68])))
                                        : null,

                                'is_checkedbox' => $row[69],
                                'full_dispatched_date2' =>
                                    !empty($row[70])
                                        ? (is_numeric($row[70])
                                        ? $this->excelDateToDate($row[70])
                                        : date('Y-m-d', strtotime($row[70])))
                                        : null,
                                'machine_channel_received_date' =>
                                    !empty($row[71])
                                        ? (is_numeric($row[71])
                                        ? $this->excelDateToDate($row[71])
                                        : date('Y-m-d', strtotime($row[71])))
                                        : null,
                                'machine_channel_dispatch_status' => $machine_channel_dispatch_statusId ,
                                'machine_channel_dispatch_date' =>
                                    !empty($row[73])
                                        ? (is_numeric($row[73])
                                        ? $this->excelDateToDate($row[73])
                                        : date('Y-m-d', strtotime($row[73])))
                                        : null,
                                'machine_available_date' =>
                                    !empty($row[74])
                                        ? (is_numeric($row[74])
                                        ? $this->excelDateToDate($row[74])
                                        : date('Y-m-d', strtotime($row[74])))
                                        : null,
                                'machine_dispatch_status' => $machine_dispatch_statusId,
                                'machine_dispatch_date' =>
                                    !empty($row[76])
                                        ? (is_numeric($row[76])
                                        ? $this->excelDateToDate($row[76])
                                        : date('Y-m-d', strtotime($row[76])))
                                        : null,
                                'car_frame_received_date' =>
                                    !empty($row[77])
                                        ? (is_numeric($row[77])
                                        ? $this->excelDateToDate($row[77])
                                        : date('Y-m-d', strtotime($row[77])))
                                        : null,
                                'car_frame_dispatch_status' => $car_frame_dispatch_statusId ,
                                'car_frame_dispatch_date' =>
                                    !empty($row[79])
                                        ? (is_numeric($row[79])
                                        ? $this->excelDateToDate($row[79])
                                        : date('Y-m-d', strtotime($row[79])))
                                        : null,
                                'cwt_frame_received_date' =>
                                    !empty($row[80])
                                        ? (is_numeric($row[80])
                                        ? $this->excelDateToDate($row[80])
                                        : date('Y-m-d', strtotime($row[80])))
                                        : null,
                                'cwt_frame_dispatch_status' => $cwt_frame_dispatch_statusId ,
                                'cwt_frame_dispatch_date' =>
                                    !empty($row[82])
                                        ? (is_numeric($row[82])
                                        ? $this->excelDateToDate($row[82])
                                        : date('Y-m-d', strtotime($row[82])))
                                        : null,
                                'rope_available_date' =>
                                    !empty($row[83])
                                        ? (is_numeric($row[83])
                                        ? $this->excelDateToDate($row[83])
                                        : date('Y-m-d', strtotime($row[83])))
                                        : null,
                                'rope_dispatch_status' => $rope_dispatch_statusId ,
                                'rope_dispatch_date' =>
                                    !empty($row[85])
                                        ? (is_numeric($row[85])
                                        ? $this->excelDateToDate($row[85])
                                        : date('Y-m-d', strtotime($row[85])))
                                        : null,
                                'osg_assy_available_date' =>
                                    !empty($row[86])
                                        ? (is_numeric($row[86])
                                        ? $this->excelDateToDate($row[86])
                                        : date('Y-m-d', strtotime($row[86])))
                                        : null,
                                'osg_assy_dispatch_status' => $osg_assy_dispatch_statusId ,
                                'osg_assy_dispatch_date' =>
                                    !empty($row[88])
                                        ? (is_numeric($row[88])
                                        ? $this->excelDateToDate($row[88])
                                        : date('Y-m-d', strtotime($row[88])))
                                        : null,

                                'is_check' => $row[89],
                                'full_dispatched_date3' =>
                                    !empty($row[90])
                                        ? (is_numeric($row[90])
                                        ? $this->excelDateToDate($row[90])
                                        : date('Y-m-d', strtotime($row[90])))
                                        : null,
                                'cabin_received_date' =>
                                    !empty($row[91])
                                        ? (is_numeric($row[91])
                                        ? $this->excelDateToDate($row[91])
                                        : date('Y-m-d', strtotime($row[91])))
                                        : null,
                                'cabin_dispatch_status' => $cabin_dispatch_statusId,
                                'cabin_dispatch_date' =>
                                    !empty($row[93])
                                        ? (is_numeric($row[93])
                                        ? $this->excelDateToDate($row[93])
                                        : date('Y-m-d', strtotime($row[93])))
                                        : null,
                                'controller_available_date' =>
                                    !empty($row[94])
                                        ? (is_numeric($row[94])
                                        ? $this->excelDateToDate($row[94])
                                        : date('Y-m-d', strtotime($row[94])))
                                        : null,
                                'controller_dispatch_status' => $controller_dispatch_statusId,
                                'controller_dispatch_date' =>
                                    !empty($row[96])
                                        ? (is_numeric($row[96])
                                        ? $this->excelDateToDate($row[96])
                                        : date('Y-m-d', strtotime($row[96])))
                                        : null,
                                'car_door_received_date' =>
                                    !empty($row[97])
                                        ? (is_numeric($row[97])
                                        ? $this->excelDateToDate($row[97])
                                        : date('Y-m-d', strtotime($row[97])))
                                        : null,
                                'car_door_dispatch_status' => $car_door_dispatch_statusId,
                                'car_door__dispatch_date' =>
                                    !empty($row[99])
                                        ? (is_numeric($row[99])
                                        ? $this->excelDateToDate($row[99])
                                        : date('Y-m-d', strtotime($row[99])))
                                        : null,
                                'cop_lop_received_date' =>
                                    !empty($row[100])
                                        ? (is_numeric($row[100])
                                        ? $this->excelDateToDate($row[100])
                                        : date('Y-m-d', strtotime($row[100])))
                                        : null,
                                'cop_lop_dispatch_status' => $cop_lop_dispatch_statusId,
                                'cop_lop__dispatch_date' =>
                                    !empty($row[102])
                                        ? (is_numeric($row[102])
                                        ? $this->excelDateToDate($row[103])
                                        : date('Y-m-d', strtotime($row[102])))
                                        : null,
                                'harness_available_date' =>
                                    !empty($row[103])
                                        ? (is_numeric($row[103])
                                        ? $this->excelDateToDate($row[103])
                                        : date('Y-m-d', strtotime($row[103])))
                                        : null,
                                'harness_dispatch_status' => $harness_dispatch_statusId,
                                'harness_dispatch_date' =>
                                    !empty($row[105])
                                        ? (is_numeric($row[105])
                                        ? $this->excelDateToDate($row[105])
                                        : date('Y-m-d', strtotime($row[105])))
                                        : null,
                            ]);

                            Flash::success('Updated Successfully. Job No: ' . $row[1]);
                        }
                        else {
                            $jobwiseproduction = JobWiseProduction::create([
                                'place' => $row[0],
                                'job_no' => $row[1],
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' =>
                                    !empty($row[3])
                                        ? (is_numeric($row[3])
                                        ? $this->excelDateToDate($row[3])
                                        : date('Y-m-d', strtotime($row[3])))
                                        : null,
                                'crm_confirmation_date' =>
                                    !empty($row[4])
                                        ? (is_numeric($row[4])
                                        ? $this->excelDateToDate($row[4])
                                        : date('Y-m-d', strtotime($row[4])))
                                        : null,
                                'customer_id' => $row[5],
                                'addressu' => $row[6],
                                'specifications' => $row[7],

                                'car_bracket' => $car_bracketId,
                                'car_bracket_readiness_status' => $car_bracket_readiness_statusId,
                                'car_bracket_readiness_date' =>
                                    !empty($row[10])
                                        ? (is_numeric($row[10])
                                        ? $this->excelDateToDate($row[10])
                                        : date('Y-m-d', strtotime($row[10])))
                                        : null,
                                'cwt_bracket' => $cwt_bracketId,
                                'cwt_bracket_readiness_status' => $cwt_bracket_readiness_statusId,
                                'cwt_bracket_readiness_date' =>
                                    !empty($row[13])
                                        ? (is_numeric($row[13])
                                        ? $this->excelDateToDate($row[13])
                                        : date('Y-m-d', strtotime($row[13])))
                                        : null,
                                'ld_opening' => $ld_openingId,
                                'ld_finish' => $ld_finishId,
                                'ld_frame_status' => $ld_frame_statusId,
                                'ld_frame_readiness_date' =>
                                    !empty($row[17])
                                        ? (is_numeric($row[17])
                                        ? $this->excelDateToDate($row[17])
                                        : date('Y-m-d', strtotime($row[17])))
                                        : null,
                                'ld_status' => $ld_statusId,
                                'ld_readiness_date' =>
                                    !empty($row[19])
                                        ? (is_numeric($row[19])
                                        ? $this->excelDateToDate($row[19])
                                        : date('Y-m-d', strtotime($row[19])))
                                        : null,
                                'comments' => $row[20],

                                'machine_channel_type' => $machine_channel_typeId,
                                'machine_channel_readiness_status' => $machine_channel_readiness_statusId,
                                'machine_channel_readiness_date' =>
                                    !empty($row[23])
                                        ? (is_numeric($row[23])
                                        ? $this->excelDateToDate($row[23])
                                        : date('Y-m-d', strtotime($row[23])))
                                        : null,
                                'machine' => $machineId,
                                'machine_readiness_status' => $machine_readiness_statusId,
                                'machine_readiness_date' =>
                                    !empty($row[26])
                                        ? (is_numeric($row[26])
                                        ? $this->excelDateToDate($row[26])
                                        : date('Y-m-d', strtotime($row[26])))
                                        : null,
                                'car_frame' => $car_frameId,
                                'car_frame_readiness_status' => $car_frame_readiness_statusId,
                                'car_frame_readiness_date' =>
                                    !empty($row[29])
                                        ? (is_numeric($row[29])
                                        ? $this->excelDateToDate($row[29])
                                        : date('Y-m-d', strtotime($row[29])))
                                        : null,
                                'cwt_frame' => $cwt_frameId,
                                'cwt_frame_readiness_status' => $cwt_frame_readiness_statusId,
                                'cwt_frame_readiness_date' =>
                                    !empty($row[32])
                                        ? (is_numeric($row[32])
                                        ? $this->excelDateToDate($row[32])
                                        : date('Y-m-d', strtotime($row[32])))
                                        : null,
                                'rope_available' => $rope_availableId,
                                'osg_assy_available' => $osg_assy_availableId,
                                'comment_after_osg' => $row[35],

                                'cabin' => $cabinId,
                                'cabin_readiness_status' => $cabin_readiness_statusId,
                                'cabin_readiness_date' =>
                                    !empty($row[38])
                                        ? (is_numeric($row[38])
                                        ? $this->excelDateToDate($row[38])
                                        : date('Y-m-d', strtotime($row[38])))
                                        : null,
                                'controller' => $controllerId,
                                'controller_readiness_status' => $controller_readiness_statusId,
                                'controller_readiness_date' =>
                                    !empty($row[41])
                                        ? (is_numeric($row[41])
                                        ? $this->excelDateToDate($row[41])
                                        : date('Y-m-d', strtotime($row[41])))
                                        : null,
                                'car_door_opening' => $car_door_openingId,
                                'car_door_finish' => $car_door_finishId,
                                'car_door_readiness_status' => $car_door_readiness_statusId,
                                'car_door_readiness_date' =>
                                    !empty($row[45])
                                        ? (is_numeric($row[45])
                                        ? $this->excelDateToDate($row[45])
                                        : date('Y-m-d', strtotime($row[45])))
                                        : null,
                                'cop_lop' => $cop_lopId,
                                'cop_lop_readiness_status' => $cop_lop_readiness_statusId,
                                'cop_lop_readiness_date' =>
                                    !empty($row[48])
                                        ? (is_numeric($row[48])
                                        ? $this->excelDateToDate($row[48])
                                        : date('Y-m-d', strtotime($row[48])))
                                        : null,
                                'harness' => $harnessId,
                                'harness_readiness_status' => $harness_readiness_statusId,
                                'harness_readiness_date' =>
                                    !empty($row[51])
                                        ? (is_numeric($row[51])
                                        ? $this->excelDateToDate($row[51])
                                        : date('Y-m-d', strtotime($row[51])))
                                        : null,
                                'commentscommentscomments' => $row[52],

                                'is_revised' => $row[53],
                                'full_dispatched_date1' =>
                                    !empty($row[54])
                                        ? (is_numeric($row[54])
                                        ? $this->excelDateToDate($row[54])
                                        : date('Y-m-d', strtotime($row[54])))
                                        : null,
                                'car_bracket_available_status' => $car_bracket_available_statusId,
                                'car_bracket_available_date' =>
                                    !empty($row[56])
                                        ? (is_numeric($row[56])
                                        ? $this->excelDateToDate($row[56])
                                        : date('Y-m-d', strtotime($row[56])))
                                        : null,
                                'car_bracket_dispatch_status' => $car_bracket_dispatch_statusId,
                                'car_bracket_dispatch_date' =>
                                    !empty($row[58])
                                        ? (is_numeric($row[58])
                                        ? $this->excelDateToDate($row[58])
                                        : date('Y-m-d', strtotime($row[58])))
                                        : null,
                                'cwt_bracket_available_status' => $cwt_bracket_available_statusId,
                                'cwt_bracket_available_date' =>
                                    !empty($row[60])
                                        ? (is_numeric($row[60])
                                        ? $this->excelDateToDate($row[60])
                                        : date('Y-m-d', strtotime($row[60])))
                                        : null,
                                'cwt_bracket_dispatch_status' => $cwt_bracket_dispatch_statusId,
                                'cwt_bracket_dispatch_date' =>
                                    !empty($row[62])
                                        ? (is_numeric($row[62])
                                        ? $this->excelDateToDate($row[62])
                                        : date('Y-m-d', strtotime($row[62])))
                                        : null,
                                'ld_frame_received_date' =>
                                    !empty($row[63])
                                        ? (is_numeric($row[63])
                                        ? $this->excelDateToDate($row[63])
                                        : date('Y-m-d', strtotime($row[63])))
                                        : null,
                                'ld_frame_dispatch_status' => $ld_frame_dispatch_statusId,
                                'ld_frame_dispatch_date' =>
                                    !empty($row[65])
                                        ? (is_numeric($row[65])
                                        ? $this->excelDateToDate($row[65])
                                        : date('Y-m-d', strtotime($row[65])))
                                        : null,
                                'ld_received_date' =>
                                    !empty($row[66])
                                        ? (is_numeric($row[66])
                                        ? $this->excelDateToDate($row[66])
                                        : date('Y-m-d', strtotime($row[66])))
                                        : null,
                                'ld_dispatch_status' => $ld_dispatch_statusId,
                                'ld_dispatch_date' =>
                                    !empty($row[68])
                                        ? (is_numeric($row[68])
                                        ? $this->excelDateToDate($row[68])
                                        : date('Y-m-d', strtotime($row[68])))
                                        : null,

                                'is_checkedbox' => $row[69],
                                'full_dispatched_date2' =>
                                    !empty($row[70])
                                        ? (is_numeric($row[70])
                                        ? $this->excelDateToDate($row[70])
                                        : date('Y-m-d', strtotime($row[70])))
                                        : null,
                                'machine_channel_received_date' =>
                                    !empty($row[71])
                                        ? (is_numeric($row[71])
                                        ? $this->excelDateToDate($row[71])
                                        : date('Y-m-d', strtotime($row[71])))
                                        : null,
                                'machine_channel_dispatch_status' => $machine_channel_dispatch_statusId ,
                                'machine_channel_dispatch_date' =>
                                    !empty($row[73])
                                        ? (is_numeric($row[73])
                                        ? $this->excelDateToDate($row[73])
                                        : date('Y-m-d', strtotime($row[73])))
                                        : null,
                                'machine_available_date' =>
                                    !empty($row[74])
                                        ? (is_numeric($row[74])
                                        ? $this->excelDateToDate($row[74])
                                        : date('Y-m-d', strtotime($row[74])))
                                        : null,
                                'machine_dispatch_status' => $machine_dispatch_statusId,
                                'machine_dispatch_date' =>
                                    !empty($row[76])
                                        ? (is_numeric($row[76])
                                        ? $this->excelDateToDate($row[76])
                                        : date('Y-m-d', strtotime($row[76])))
                                        : null,
                                'car_frame_received_date' =>
                                    !empty($row[77])
                                        ? (is_numeric($row[77])
                                        ? $this->excelDateToDate($row[77])
                                        : date('Y-m-d', strtotime($row[77])))
                                        : null,
                                'car_frame_dispatch_status' => $car_frame_dispatch_statusId ,
                                'car_frame_dispatch_date' =>
                                    !empty($row[79])
                                        ? (is_numeric($row[79])
                                        ? $this->excelDateToDate($row[79])
                                        : date('Y-m-d', strtotime($row[79])))
                                        : null,
                                'cwt_frame_received_date' =>
                                    !empty($row[80])
                                        ? (is_numeric($row[80])
                                        ? $this->excelDateToDate($row[80])
                                        : date('Y-m-d', strtotime($row[80])))
                                        : null,
                                'cwt_frame_dispatch_status' => $cwt_frame_dispatch_statusId ,
                                'cwt_frame_dispatch_date' =>
                                    !empty($row[82])
                                        ? (is_numeric($row[82])
                                        ? $this->excelDateToDate($row[82])
                                        : date('Y-m-d', strtotime($row[82])))
                                        : null,
                                'rope_available_date' =>
                                    !empty($row[83])
                                        ? (is_numeric($row[83])
                                        ? $this->excelDateToDate($row[83])
                                        : date('Y-m-d', strtotime($row[83])))
                                        : null,
                                'rope_dispatch_status' => $rope_dispatch_statusId ,
                                'rope_dispatch_date' =>
                                    !empty($row[85])
                                        ? (is_numeric($row[85])
                                        ? $this->excelDateToDate($row[85])
                                        : date('Y-m-d', strtotime($row[85])))
                                        : null,
                                'osg_assy_available_date' =>
                                    !empty($row[86])
                                        ? (is_numeric($row[86])
                                        ? $this->excelDateToDate($row[86])
                                        : date('Y-m-d', strtotime($row[86])))
                                        : null,
                                'osg_assy_dispatch_status' => $osg_assy_dispatch_statusId ,
                                'osg_assy_dispatch_date' =>
                                    !empty($row[88])
                                        ? (is_numeric($row[88])
                                        ? $this->excelDateToDate($row[88])
                                        : date('Y-m-d', strtotime($row[88])))
                                        : null,

                                'is_check' => $row[89],
                                'full_dispatched_date3' =>
                                    !empty($row[90])
                                        ? (is_numeric($row[90])
                                        ? $this->excelDateToDate($row[90])
                                        : date('Y-m-d', strtotime($row[90])))
                                        : null,
                                'cabin_received_date' =>
                                    !empty($row[91])
                                        ? (is_numeric($row[91])
                                        ? $this->excelDateToDate($row[91])
                                        : date('Y-m-d', strtotime($row[91])))
                                        : null,
                                'cabin_dispatch_status' => $cabin_dispatch_statusId,
                                'cabin_dispatch_date' =>
                                    !empty($row[93])
                                        ? (is_numeric($row[93])
                                        ? $this->excelDateToDate($row[93])
                                        : date('Y-m-d', strtotime($row[93])))
                                        : null,
                                'controller_available_date' =>
                                    !empty($row[94])
                                        ? (is_numeric($row[94])
                                        ? $this->excelDateToDate($row[94])
                                        : date('Y-m-d', strtotime($row[94])))
                                        : null,
                                'controller_dispatch_status' => $controller_dispatch_statusId,
                                'controller_dispatch_date' =>
                                    !empty($row[96])
                                        ? (is_numeric($row[96])
                                        ? $this->excelDateToDate($row[96])
                                        : date('Y-m-d', strtotime($row[96])))
                                        : null,
                                'car_door_received_date' =>
                                    !empty($row[97])
                                        ? (is_numeric($row[97])
                                        ? $this->excelDateToDate($row[97])
                                        : date('Y-m-d', strtotime($row[97])))
                                        : null,
                                'car_door_dispatch_status' => $car_door_dispatch_statusId,
                                'car_door__dispatch_date' =>
                                    !empty($row[99])
                                        ? (is_numeric($row[99])
                                        ? $this->excelDateToDate($row[99])
                                        : date('Y-m-d', strtotime($row[99])))
                                        : null,
                                'cop_lop_received_date' =>
                                    !empty($row[100])
                                        ? (is_numeric($row[100])
                                        ? $this->excelDateToDate($row[100])
                                        : date('Y-m-d', strtotime($row[100])))
                                        : null,
                                'cop_lop_dispatch_status' => $cop_lop_dispatch_statusId,
                                'cop_lop__dispatch_date' =>
                                    !empty($row[102])
                                        ? (is_numeric($row[102])
                                        ? $this->excelDateToDate($row[103])
                                        : date('Y-m-d', strtotime($row[102])))
                                        : null,
                                'harness_available_date' =>
                                    !empty($row[103])
                                        ? (is_numeric($row[103])
                                        ? $this->excelDateToDate($row[103])
                                        : date('Y-m-d', strtotime($row[103])))
                                        : null,
                                'harness_dispatch_status' => $harness_dispatch_statusId,
                                'harness_dispatch_date' =>
                                    !empty($row[105])
                                        ? (is_numeric($row[105])
                                        ? $this->excelDateToDate($row[105])
                                        : date('Y-m-d', strtotime($row[105])))
                                        : null,
                            ]);

                            Flash::success('Imported Successfully. Job No: ' . $jobwiseproduction->job_no);
                        }
                    }
                }
            }
            return redirect()->back();
        }
    }

    function excelDateToDate($serial) {
        $unixDate = ($serial - 25569) * 86400;
        return date("Y-m-d", $unixDate);
    }

    public function exportjobwiseproduction()
    {
        $filename ="Job Wise Production.xlsx";
        return Excel::download(new JobWiseProductionExport, $filename);
        Flash::success('exported Successfully');
        return redirect(url('job_wise_production'));
    }

    public function importExportjobwiseproduction()
    {
        return view('job_wise_production.importJobWiseProductionview');
    }

}