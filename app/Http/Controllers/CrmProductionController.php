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
use App\Models\Production;
use App\Models\customers;
use App\Models\ProductionProject;
use App\Models\StageOfMaterial;
use App\Models\DispatchPaymentStatus;
use App\Models\Priority;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;
use App\Models\ProductionSom;
use App\Models\ProductionMnfStage;
use App\Models\CrmProduction;
use App\Models\Crm;
use App\Models\DispatchStatus;
use App\Models\DispatchStageLotStatus;
use App\Models\CrmProductionDispatch;
use App\Http\Requests\CreatecustomersRequest;
use App\Repositories\customersRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Imports\CrmProductionImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CrmProductionExport;
use App\Models\JobWiseProduction;
use DateTime;

class CrmProductionController extends AppBaseController
{
    private $customersRepository;

    public function __construct(customersRepository $customersRepo)
    {
//        $this->middleware('auth');
        $this->customersRepository = $customersRepo;
    }

     public function index(Request $request)
    {
        $data = CrmProduction::with('getDispatchStatusData')->get();

         return view('crm_production.index')->with('data', $data);
//          return CrmProductionDispatch::get();
//          return $data;
    }

    public function customerStore(CreatecustomersRequest $request)
    {

        // Log the incoming data before validation
        Log::info('Incoming request data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'contact_number' => 'unique:customers,contact_number|size:10',
            'password' => 'min:6',
            'address' => 'nullable|string',
            'siteaddress' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $input = $request->all();

            // Log the final input data
            Log::info('Processed input data: ', $input);

            // Create the customer
            $customer = $this->customersRepository->create($input);

            return response()->json([
                'success' => true,
                'message' => 'Customer saved successfully',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        $customer = customers::where('is_deleted', 0)->get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_production = ManufactureStatus::where('is_deleted', 0)->get();
        $crm = Crm::where('is_deleted', 0)->get();
        $dispatch_payments_status=DispatchPaymentStatus::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $dispatch_stage_lots_status = DispatchStageLotStatus::where('is_deleted', 0)->get();
        return view('crm_production.create',compact('customer', 'stage_of_material','priority','manufacture_production','manufacture_stages','manufacture_status','crm','dispatch_payments_status','dispatch_status','dispatch_stage_lots_status'));
    }

    public function store(Request $request)
       {
        if(isset($request->is_revised) && $request->is_revised == 'on')
        {
            $validatedData = $request->validate([
                'factory_commitment_date' => 'required',
            ]);
        }

        $validatedData = $request->validate([
            'crm_id' => 'required|string|max:255',
            'payment_received_manufacturing_date' => 'required|date',
            'crm_confirmation_date' =>  'required|date',
            'job_no' =>  'required|string|max:255|unique:crmproductions',
            'customer_id' => 'required|string|max:255',
            'addressu' => 'required',
            'contract_value' => 'required',
            'stage_of_materials_id' => 'required',
            'priority_id' => 'nullable|string',
            'requested_date_for_start_of_manufacturing_from_teknix_office' => 'required|date',
            'dispatch_request_date_from_teknix_office' => 'required|date',
            'dispatch_payments_status_id' => 'required|string|max:255',
            'amount_pending_for_dispatch' => 'required|string|max:255',
            'dispatch_comment' => 'required|string|max:255',
            'specifications' => 'required',
            'manufacture_status_id' =>  'nullable',
            'manufacture_stages_id' => 'required|string|max:255',
            'manufacture_completion_date' => 'required|string|max:255',
            'manufacture_comment' => 'required',

            'material_received_date_from_factory' => 'required',
            'no_of_days_since_ready_for_dispatch' => 'nullable',

            'comments' => 'nullable|string',
            'dispatch_stage_lots_status_id' => 'nullable|array',
            'dispatch_stage_lots_status_id.*' => 'nullable|string|max:255',
            'plandispatch_date' => 'nullable|array',
            'dispatch_status_id' => 'nullable|array',
            'dispatch_status_id.*' => 'nullable|string|max:255',
            'go_down_dispatch_completion_date' => 'nullable|array',
        ]);

           if (\App\Models\CrmProduction::where('job_no', $request->job_no)->exists()) {
               return redirect()->back()->withErrors(['job_no' => 'The job number already exists.'])->withInput();
           }

        $crmproduction = new CrmProduction;
        $crmproduction->crm_id = $request->crm_id;
        $crmproduction->payment_received_manufacturing_date = $request->payment_received_manufacturing_date;
        $crmproduction->crm_confirmation_date = $request->crm_confirmation_date;
        $crmproduction->job_no = $request->job_no;
        $crmproduction->customer_id = $request->customer_id;
        $crmproduction->addressu = $request->addressu;
        $crmproduction->contract_value = $request->contract_value;
        $crmproduction->stage_of_materials_id = $request->stage_of_materials_id;
        $crmproduction->priority_id = $request->priority_id;
        $crmproduction->requested_date_for_start_of_manufacturing_from_teknix_office = $request->requested_date_for_start_of_manufacturing_from_teknix_office;
        $crmproduction->dispatch_request_date_from_teknix_office = $request->dispatch_request_date_from_teknix_office;
        $crmproduction->dispatch_payments_status_id = $request->dispatch_payments_status_id;
        $crmproduction->amount_pending_for_dispatch = $request->amount_pending_for_dispatch;
        $crmproduction->dispatch_comment = $request->dispatch_comment;
        $crmproduction->specifications = $request->specifications;
        $crmproduction->factory_commitment_date = $request->factory_commitment_date;
        $crmproduction->manufacture_status_id = $request->manufacture_status_id;
        $crmproduction->manufacture_stages_id = $request->manufacture_stages_id;
        $crmproduction->manufacture_completion_date = $request->manufacture_completion_date;
        $crmproduction->manufacture_comment = $request->manufacture_comment;

        $crmproduction->material_received_date_from_factory = $request->material_received_date_from_factory;
        $crmproduction->no_of_days_since_ready_for_dispatch = $request->no_of_days_since_ready_for_dispatch;

        $crmproduction->is_revised = $request->is_revised ? 1 : 0;
        $crmproduction->comments = $request->comments;

       $checkIfjwpExist = \App\Models\JobWiseProduction::where('job_no', $request->job_no)->first();
       if (empty($checkIfjwpExist)) {
           $jobwiseproduction = new JobWiseProduction;
           $jobwiseproduction->job_no = $request->job_no;
           $jobwiseproduction->crm_id = $request->crm_id;
           $jobwiseproduction->payment_received_manufacturing_date = $request->payment_received_manufacturing_date;
           $jobwiseproduction->crm_confirmation_date = $request->crm_confirmation_date;
           $jobwiseproduction->customer_id = $request->customer_id;
           $jobwiseproduction->addressu = $request->addressu;
           $jobwiseproduction->specifications = $request->specifications;
           $jobwiseproduction->created_from_crm = true;
           $jobwiseproduction->save();
       }

       $crmproduction->created_from_crm = true;
       $crmproduction->save();



        if (isset($request->dispatch_stage_lots_status_id) && count($request->dispatch_stage_lots_status_id) > 0){
            foreach ($request->dispatch_stage_lots_status_id as $key => $item){

                $data = [
                    'crmproductions_id' => $crmproduction->id,
                    'dispatch_stage_lots_status_id' => $request->dispatch_stage_lots_status_id[$key],
                    'plandispatch_date' => $request->plandispatch_date[$key],
                    'dispatch_status_id' => $request->dispatch_status_id[$key],
                    'go_down_dispatch_completion_date' => $request->go_down_dispatch_completion_date[$key],
                ];
                CrmProductionDispatch::create($data);
            }
        }

           $productionProject = ProductionProject::where('job_no', $request->job_no)->first();
           $productionProjectData = [
               'job_no' => $request->job_no,
               'customer_name' => $request->customer_id,
               'crm_id' => $request->crm_id,
               'payment_received_manufacturing_date' => $request->payment_received_manufacturing_date,
               'crm_confirmation_date' => $request->crm_confirmation_date,
               'address' => $request->addressu,
               'specifications' => $request->specifications,
           ];
           if ($productionProject) {
               $productionProject->update($productionProjectData);
           } else {
               ProductionProject::create($productionProjectData);
           }
        Flash::success('Saved Successfully.');

        return redirect(url('crm_production'));
    }

    public function edit($id)
    {

        $customer = customers::where('is_deleted', 0)->get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_production = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        $crm = Crm::where('is_deleted', 0)->get();
        $dispatch_payments_status=DispatchPaymentStatus::where('is_deleted', 0)->get();
        $dispatch_stage_lots_status = DispatchStageLotStatus::where('is_deleted', 0)->get();
        $crm_prod_dispatch = CrmProductionDispatch::where('crmproductions_id', $id)->get();
        $data = CrmProduction::with('getDispatchStatusData')->whereId($id)->first();


        if (empty($data)){
            Flash::error('Not Found.');
            return redirect(url('crm_production'));
        }
        return view('crm_production.edit', compact('data','customer','stage_of_material','dispatch_status', 'manufacture_production','manufacture_stages','manufacture_status','priority','crm','dispatch_payments_status','dispatch_stage_lots_status','crm_prod_dispatch'));
    }
    
    public function update($id, Request $request)
    {
        if(isset($request->is_revised) && $request->is_revised == 'on')
        {
            $validatedData = $request->validate
            ([
                'factory_commitment_date' => 'required',
            ]);
        }
        
        $crmproduction = CrmProduction::whereId($id)->first();

        if (empty($crmproduction)) {
            Flash::error('Not Found');
            return redirect(url('crm_production'));
        }

        $crmproduction->crm_id = $request->crm_id;
        $crmproduction->payment_received_manufacturing_date = $request->payment_received_manufacturing_date;
        $crmproduction->crm_confirmation_date = $request->crm_confirmation_date;
        $crmproduction->job_no = $request->job_no;
        $crmproduction->customer_id = $request->customer_id;
        $crmproduction->addressu = $request->addressu;
        $crmproduction->contract_value = $request->contract_value;
        $crmproduction->stage_of_materials_id = $request->stage_of_materials_id;
        $crmproduction->priority_id = $request->priority_id;
        $crmproduction->requested_date_for_start_of_manufacturing_from_teknix_office = $request->requested_date_for_start_of_manufacturing_from_teknix_office;
        $crmproduction->dispatch_request_date_from_teknix_office = $request->dispatch_request_date_from_teknix_office;
        $crmproduction->dispatch_payments_status_id = $request->dispatch_payments_status_id;
        $crmproduction->amount_pending_for_dispatch = $request->amount_pending_for_dispatch;
        $crmproduction->dispatch_comment = $request->dispatch_comment;
        $crmproduction->specifications = $request->specifications;
        $crmproduction->factory_commitment_date = $request->factory_commitment_date;
        $crmproduction->manufacture_status_id = $request->manufacture_status_id;
        $crmproduction->manufacture_stages_id = $request->manufacture_stages_id;
        $crmproduction->manufacture_completion_date = $request->manufacture_completion_date;
        $crmproduction->manufacture_comment = $request->manufacture_comment;
        $crmproduction->material_received_date_from_factory = $request->material_received_date_from_factory;
        $crmproduction->no_of_days_since_ready_for_dispatch = $request->no_of_days_since_ready_for_dispatch;
        $crmproduction->comments = $request->comments;
        $crmproduction->is_revised = $request->is_revised ? 1 : 0;

        $crmproduction->save();

        if (isset($request->dispatch_stage_lots_status_id) && count($request->dispatch_stage_lots_status_id) > 0){
            CrmProductionDispatch::where('crmproductions_id', $id)->delete();
            foreach ($request->dispatch_stage_lots_status_id as $key => $item){
                $data = [
                    'crmproductions_id' => $crmproduction->id,
                    'dispatch_stage_lots_status_id' => $request->dispatch_stage_lots_status_id[$key],
                    'plandispatch_date' => $request->plandispatch_date[$key],
                    'dispatch_status_id' => $request->dispatch_status_id[$key],
                    'go_down_dispatch_completion_date' => $request->go_down_dispatch_completion_date[$key],
                ];
                CrmProductionDispatch::create($data);
            }
        }
        Flash::success('Updated Successfully.');
        return redirect(url('crm_production'));
    }

    public function delete($id)
    {
        $data = CrmProduction::whereId($id)->first();
        if (empty($data)){
            Flash::error('Not Found');
            return redirect(url('crm_production'));
        }

        CrmProduction::whereId($id)->delete();
        CrmProductionDispatch::where('crmproductions_id', $id)->delete();

        Flash::success('Deleted Successfully');
        return redirect(url('crm_production'));
    }

    public function crmimport(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls'
        ]);

        if ($request->hasFile('import_file')) {
            $file = $request->file('import_file');

            $rows = Excel::toArray(new CrmProductionImport, $file)[0];

            if (empty($rows) || count($rows) === 0) {
                Flash::error('File is empty.');
                return redirect()->back();
            }

            $header = $rows[0];
            if (empty($header) || count(array_filter($header)) === 0) {
                Flash::error('File header is missing or empty.');
                return redirect()->back();
            }

            if (isset($header[0]) && $header[0] !== 'CRM') {
                Flash::error('The first header column must be "Place".');
                return redirect()->back();
            }

            $requiredColumns = [
                "CRM",
                "Payment Received for Manufacturing Date",
                "Crm Confirmation Date",
                "Job No",
                "Customer Name",
                "Address Details",
                "Contract Value",
                "Request for Production",
                "Standard / Non standard",
                "Requested Date for Start of Manufacturing from Teknix Office",
                "Dispatch Request Date from Teknix Office",
                "Dispatch Payment Status",
                "Amount Pending for Dispatch in INR",
                "Comments",
                "Specifications",
                "Manufacturing Status",
                "Manufacturing -Stage / Lot",
                "Manufacture Completion Date",
                "Is Revised",
                "Factory Commitment Date",
                "Manufacture Comment",
                "Material Received Date From Factory",
                "No of days since ready for dispatch",
                "Dispatch - Stage / Lot",
                "Plan dispatch date",
                "Dispatch Status",
                "Go Down: Dispatch Completion Date",
                "Comments"
            ];
            foreach ($requiredColumns as $column) {
                if (!in_array($column, $header)) {
                    Flash::error("Missing required column: $column.");
                    return redirect()->back();
                }
            }

            if(count($rows) > 0){
                foreach ($rows as $key => $row) {
                    if($key > 0){
                        $crm = Crm::where('name', $row[0])->first();
                        if(empty($crm) && !empty($row[0])){
                            $crm = Crm::create([
                                'name' => $row[0]
                            ]);
                            $crmId = $crm->id;
                        }
                        else{
                            $crmId = $crm->id ?? null;
                        }

                        $stageOfMaterial = StageOfMaterial::where('title', $row[7])->first();
                        if(empty($stageOfMaterial) && !empty($row[7])){
                            $stageOfMaterial = StageOfMaterial::create([
                                'title' => $row[7]
                            ]);
                            $stageOfMaterialId = $stageOfMaterial->id;
                        }
                        else{
                            $stageOfMaterialId = $stageOfMaterial->id ?? null;
                        }

                        $priority = Priority::where('title', $row[8])->first();
                        if(empty($priority) && !empty($row[8])){
                            $priority = Priority::create([
                                'title' => $row[8]
                            ]);
                            $priorityId = $priority->id;
                        }
                        else{
                            $priorityId = $priority->id ?? null;
                        }

                        $dispatchPaymentStatus = DispatchPaymentStatus::where('Name', $row[11])->first();
                        if(empty($dispatchPaymentStatus) && !empty($row[11])){
                            $dispatchPaymentStatus = DispatchPaymentStatus::create([
                                'Name' => $row[11]
                            ]);
                            $dispatchPaymentStatusId = $dispatchPaymentStatus->id;
                        }
                        else{
                            $dispatchPaymentStatusId = $dispatchPaymentStatus->id ?? null;
                        }

                        $manufactureStatus = ManufactureStatus::where('title', $row[15])->first();
                        if(empty($manufactureStatus) && !empty($row[15])){
                            $manufactureStatus = ManufactureStatus::create([
                                'title' => $row[15]
                            ]);
                            $manufactureStatusId = $manufactureStatus->id;
                        }
                        else{
                            $manufactureStatusId = $manufactureStatus->id ?? null;
                        }

                        $manufactureStage = ManufactureStage::where('title', $row[16])->first();
                        if(empty($manufactureStage) && !empty($row[16])){
                            $manufactureStage = ManufactureStage::create([
                                'title' => $row[16]
                            ]);
                            $manufactureStageId = $manufactureStage->id;
                        }
                        else{
                            $manufactureStageId = $manufactureStage->id ?? null;
                        }

                        $dispatchStageLotStatus = DispatchStageLotStatus::where('Name', $row[23])->first();
                        if(empty($dispatchStageLotStatus) && !empty($row[23])){
                            $dispatchStageLotStatus = DispatchStageLotStatus::create([
                                'Name' => $row[23]
                            ]);
                            $dispatchStageLotStatusId = $dispatchStageLotStatus->id;
                        }
                        else{
                            $dispatchStageLotStatusId = $dispatchStageLotStatus->id ?? null;
                        }

                        $dispatchStatus = DispatchStatus::where('title', $row[25])->first();
                        if(empty($dispatchStatus) && !empty($row[25])){
                            $dispatchStatus = DispatchStatus::create([
                                'title' => $row[25]
                            ]);
                            $dispatchStatusId = $dispatchStatus->id;
                        }
                        else{
                            $dispatchStatusId = $dispatchStatus->id ?? null;
                        }

                        $customer = customers::where('name', $row[4])->first();
                        $customerId = $customer ? $customer->id : null;

                        $existingCrmProduction = CrmProduction::where('job_no', $row[3])->first();

                        $material_received_date_from_factory = !empty($row[21])
                            ? (is_numeric($row[21])
                            ? $this->excelDateToDate($row[21])
                            : date('Y-m-d', strtotime($row[21])))
                            : null;
                        $today = date('Y-m-d');

                        $start = new DateTime($material_received_date_from_factory);
                        $end = new DateTime($today);

                        $diff = $start->diff($end);
                        $no_of_days_since_ready_for_dispatch  = (int)$diff->format('%r%a');

                        if ($existingCrmProduction) {
                            CrmProduction::where('job_no', $row[3])->update([
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' =>
                                    !empty($row[1])
                                        ? (is_numeric($row[1])
                                        ? $this->excelDateToDate($row[1])
                                        : date('Y-m-d', strtotime($row[1])))
                                        : null,
                                'crm_confirmation_date' =>
                                    !empty($row[2])
                                        ? (is_numeric($row[2])
                                        ? $this->excelDateToDate($row[2])
                                        : date('Y-m-d', strtotime($row[2])))
                                        : null,
                                'job_no' => $row[3],
                                'customer_id' => $row[4],
                                'addressu' => $row[5],
                                'contract_value' => $row[6],
                                'stage_of_materials_id' => $stageOfMaterialId,
                                'priority_id' => $priorityId,
                                'requested_date_for_start_of_manufacturing_from_teknix_office' =>
                                    !empty($row[9])
                                        ? (is_numeric($row[9])
                                        ? $this->excelDateToDate($row[9])
                                        : date('Y-m-d', strtotime($row[9])))
                                        : null,
                                'dispatch_request_date_from_teknix_office' =>
                                    !empty($row[10])
                                        ? (is_numeric($row[10])
                                        ? $this->excelDateToDate($row[10])
                                        : date('Y-m-d', strtotime($row[10])))
                                        : null,
                                'dispatch_payments_status_id' => $dispatchPaymentStatusId,
                                'amount_pending_for_dispatch' => $row[12],
                                'dispatch_comment' => $row[13],
                                'specifications' => $row[14],
                                'manufacture_status_id' => $manufactureStatusId,
                                'manufacture_stages_id' => $manufactureStageId,
                                'manufacture_completion_date' =>
                                    !empty($row[17])
                                        ? (is_numeric($row[17])
                                        ? $this->excelDateToDate($row[17])
                                        : date('Y-m-d', strtotime($row[17])))
                                        : null,
                                'is_revised' => $row[18] ? 1 : 0,
                                'factory_commitment_date' =>
                                    !empty($row[19])
                                        ? (is_numeric($row[19])
                                        ? $this->excelDateToDate($row[19])
                                        : date('Y-m-d', strtotime($row[19])))
                                        : null,
                                'manufacture_comment' => $row[20],
                                'material_received_date_from_factory' => $material_received_date_from_factory,
                                'no_of_days_since_ready_for_dispatch' => $no_of_days_since_ready_for_dispatch,
                                'comments' => $row[27],
                                'created_from_crm' => 1,
                            ]);

                            $existingCrmProduction = CrmProduction::where('job_no', $row[3])->first();

                            $crmDispatch = CrmProductionDispatch::where('crmproductions_id', $existingCrmProduction->id)->latest('id')->first();
                            if ($crmDispatch) {
                                $crmDispatch->dispatch_stage_lots_status_id = $dispatchStageLotStatusId;
                                $crmDispatch->plandispatch_date =
                                    !empty($row[24])
                                        ? (is_numeric($row[24])
                                        ? $this->excelDateToDate($row[24])
                                        : date('Y-m-d', strtotime($row[24])))
                                        : null;
                                $crmDispatch->dispatch_status_id = $dispatchStatusId;
                                $crmDispatch->go_down_dispatch_completion_date =
                                    !empty($row[26])
                                        ? (is_numeric($row[26])
                                        ? $this->excelDateToDate($row[26])
                                        : date('Y-m-d', strtotime($row[26])))
                                        : null;
                                $crmDispatch->save();
                            }


                            $productionProject = ProductionProject::where('job_no', $row[3])->first();
                            $productionProjectData = [
                                'job_no' => $row[3],
                                'customer_name' => $row[4],
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' => !empty($row[1])
                                    ? (is_numeric($row[1])
                                        ? $this->excelDateToDate($row[1])
                                        : date('Y-m-d', strtotime($row[1])))
                                    : null,
                                'crm_confirmation_date' => !empty($row[2])
                                    ? (is_numeric($row[2])
                                        ? $this->excelDateToDate($row[2])
                                        : date('Y-m-d', strtotime($row[2])))
                                    : null,
                                'address' => $row[5],
                                'specifications' => $row[14],
                            ];
                            if ($productionProject) {
                                $productionProject->update($productionProjectData);
                            } else {
                                ProductionProject::create($productionProjectData);
                            }
                            Flash::success('Updated Successfully. Job No: ' . $existingCrmProduction->job_no);
                        }
                        else {
                            $crmproduction = CrmProduction::create([
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' =>
                                    !empty($row[1])
                                        ? (is_numeric($row[1])
                                        ? $this->excelDateToDate($row[1])
                                        : date('Y-m-d', strtotime($row[1])))
                                        : null,
                                'crm_confirmation_date' =>
                                    !empty($row[2])
                                        ? (is_numeric($row[2])
                                        ? $this->excelDateToDate($row[2])
                                        : date('Y-m-d', strtotime($row[2])))
                                        : null,
                                'job_no' => $row[3],
                                'customer_id' => $row[4],
                                'addressu' => $row[5],
                                'contract_value' => $row[6],
                                'stage_of_materials_id' => $stageOfMaterialId,
                                'priority_id' => $priorityId,
                                'requested_date_for_start_of_manufacturing_from_teknix_office' =>
                                    !empty($row[9])
                                        ? (is_numeric($row[9])
                                        ? $this->excelDateToDate($row[9])
                                        : date('Y-m-d', strtotime($row[9])))
                                        : null,
                                'dispatch_request_date_from_teknix_office' =>
                                    !empty($row[10])
                                        ? (is_numeric($row[10])
                                        ? $this->excelDateToDate($row[10])
                                        : date('Y-m-d', strtotime($row[10])))
                                        : null,
                                'dispatch_payments_status_id' => $dispatchPaymentStatusId,
                                'amount_pending_for_dispatch' => $row[12],
                                'dispatch_comment' => $row[13],
                                'specifications' => $row[14],
                                'manufacture_status_id' => $manufactureStatusId,
                                'manufacture_stages_id' => $manufactureStageId,
                                'manufacture_completion_date' =>
                                    !empty($row[17])
                                        ? (is_numeric($row[17])
                                        ? $this->excelDateToDate($row[17])
                                        : date('Y-m-d', strtotime($row[17])))
                                        : null,
                                'is_revised' => $row[18] ? 1 : 0,
                                'factory_commitment_date' =>
                                    !empty($row[19])
                                        ? (is_numeric($row[19])
                                        ? $this->excelDateToDate($row[19])
                                        : date('Y-m-d', strtotime($row[19])))
                                        : null,
                                'manufacture_comment' => $row[20],
                                'material_received_date_from_factory' => $material_received_date_from_factory,
                                'no_of_days_since_ready_for_dispatch' => $row[22],
                                'comments' => $row[27],
                                'created_from_crm' => 1,
                            ]);

                            CrmProductionDispatch::create([
                                'crmproductions_id' => $crmproduction->id,
                                'dispatch_stage_lots_status_id' => $dispatchStageLotStatusId,
                                'plandispatch_date' =>
                                    !empty($row[24])
                                        ? (is_numeric($row[24])
                                        ? $this->excelDateToDate($row[24])
                                        : date('Y-m-d', strtotime($row[24])))
                                        : null,
                                'dispatch_status_id' => $dispatchStatusId,
                                'go_down_dispatch_completion_date' =>
                                    !empty($row[26])
                                        ? (is_numeric($row[26])
                                        ? $this->excelDateToDate($row[26])
                                        : date('Y-m-d', strtotime($row[26])))
                                        : null,
                            ]);

                            $productionProject = ProductionProject::where('job_no', $row[3])->first();
                            $productionProjectData = [
                                'job_no' => $row[3],
                                'customer_name' => $row[4],
                                'crm_id' => $crmId,
                                'payment_received_manufacturing_date' => !empty($row[1])
                                    ? (is_numeric($row[1])
                                        ? $this->excelDateToDate($row[1])
                                        : date('Y-m-d', strtotime($row[1])))
                                    : null,
                                'crm_confirmation_date' => !empty($row[2])
                                    ? (is_numeric($row[2])
                                        ? $this->excelDateToDate($row[2])
                                        : date('Y-m-d', strtotime($row[2])))
                                    : null,
                                'address' => $row[5],
                                'specifications' => $row[14],
                            ];
                            if ($productionProject) {
                                $productionProject->update($productionProjectData);
                            } else {
                                ProductionProject::create($productionProjectData);
                            }

                            Flash::success('Imported Successfully. Job No: ' . $crmproduction->job_no);
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

    public function crmexport()
    {
        $filename ="CRM Production.xlsx";
        return Excel::download(new CrmProductionExport, $filename);
        Flash::success('exported Successfully');
        return redirect(url('crm_production'));
    }

    public function crmimportExportView()
    {
        return view('crm_production.importCrmProduction');
    }
}