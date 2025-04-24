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
use App\Models\StageOfMaterial;
use App\Models\DispatchStatus;
use App\Models\Priority;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;
use App\Models\ProductionSom;
use App\Models\ProductionMnfStage;
use App\Imports\ManufactureProductionImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ManufactureProductionExport;

class ManufactureProductionController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = Production::where('is_request', 0)->get();
        return view('manufacture_production.index')
            ->with('data', $data);
    }

    public function create()
    {
        $customer = customers::where('is_deleted', 0)->get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_production = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        return view('manufacture_production.create', compact('customer', 'stage_of_material','dispatch_status','priority','manufacture_production','manufacture_stages','manufacture_status'));
    }

    public function store(Request $request)
    {
        $production = new Production;

        $production->place = $request->place;
        $production->manager = $request->crm;
        $production->mnf_payment_date = $request->payment_received;
        $production->crm_confirmation_date = $request->crm_confirmation_date;
        $production->job_no = $request->jobs;
        $production->customer_id = $request->customer_name;
        $production->contract_value = $request->contract_value;
        $production->priority = $request->priority;
        $production->mnf_confirmation_date = $request->manufacturing_confirmation_date;
        $production->original_planned_dispatch_date = $request->original_planned_dispatch_date;
        $production->revised_planned_dispatch_date = $request->revised_planned_dispatch_date;
        $production->dispatch_payment_status = $request->dispatch_payment_status;
        $production->pending_dispatch_amount_inr = $request->amount_pending_for_dispatch;
        $production->manufacturing_status = $request->manufacturing_status_1;
        $production->dispatch_status = $request->dispatch_status;
        $production->dispatch_stage_lot = $request->dispatch_stage_lot;
        $production->comments = $request->comments;
        $production->factory_commitment_date = $request->factory_commitment_date;
        $production->revised_date_reason = $request->reason_for_revised_date;
        $production->revised_planed_dispatch = $request->revised_planed_dispatch_date;
        $production->dispatch_date_reason_factory = $request->reason_dispatch_date_factory;
        $production->revised_commitment_date_factory = $request->revised_commitment_date_factory;
        $production->material_readiness = $request->material_readiness;
        $production->completion_status = $request->status_of_completion;
        $production->no_of_days = $request->no_of_days;
        $production->dispatch_date = $request->dispatch_date;
        $production->specification = $request->specification;
        $production->issue = $request->issue;
        $production->address = $request->address_details;

        $production->save();
        
        if (isset($request->stage_of_material) && count($request->stage_of_material) > 0){
            foreach ($request->stage_of_material as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'som_id' => $request->stage_of_material[$key],
                    'note' => $request->stage_of_material_note[$key] ?? null,
                ];
                ProductionSom::create($data);
            }
        }

        if (isset($request->manufacturing_by) && count($request->manufacturing_by) > 0){
            foreach ($request->manufacturing_by as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'ms_id' => $request->manufacturing_stage[$key],
                    'status' => $request->manufacturing_status[$key],
                    'production_date' => $request->production_date[$key],
                    'readiness_date' => $request->readiness_date[$key],
                    'mf_by' => $request->manufacturing_by[$key],
                ];
                ProductionMnfStage::create($data);
            }
        }

        Flash::success('Saved Successfully.');

        return redirect(url('manufacture_production'));
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

        $data = Production::whereId($id)->first();
        $p_som = ProductionSom::where('prod_id', $id)->get();
        $p_mns = ProductionMnfStage::where('prod_id', $id)->get();
        if (empty($data)){
            Flash::error('Not Found.');
            return redirect(url('manufacture_production'));
        }
        return view('manufacture_production.edit', compact('data','customer','stage_of_material','dispatch_status', 'manufacture_production','manufacture_stages','manufacture_status','priority','p_som', 'p_mns'));
    }

    public function update($id, Request $request)
    {
        $production = Production::whereId($id)->first();

        if (empty($production)){
            Flash::error('Not Found');
            return redirect(url('manufacture_production'));
        }

        $production->place = $request->place;
        $production->manager = $request->crm;
        $production->mnf_payment_date = $request->payment_received;
        $production->crm_confirmation_date = $request->crm_confirmation_date;
        $production->job_no = $request->jobs;
        $production->customer_id = $request->customer_name;
        $production->contract_value = $request->contract_value;
        $production->priority = $request->priority;
        $production->mnf_confirmation_date = $request->manufacturing_confirmation_date;
        $production->original_planned_dispatch_date = $request->original_planned_dispatch_date;
        $production->revised_planned_dispatch_date = $request->revised_planned_dispatch_date;
        $production->dispatch_payment_status = $request->dispatch_payment_status;
        $production->pending_dispatch_amount_inr = $request->amount_pending_for_dispatch;
        $production->manufacturing_status = $request->manufacturing_status_1;
        $production->dispatch_status = $request->dispatch_status;
        $production->dispatch_stage_lot = $request->dispatch_stage_lot;
        $production->comments = $request->comments;
        $production->factory_commitment_date = $request->factory_commitment_date;
        $production->revised_date_reason = $request->reason_for_revised_date;
        $production->revised_planed_dispatch = $request->revised_planed_dispatch_date;
        $production->dispatch_date_reason_factory = $request->reason_dispatch_date_factory;
        $production->revised_commitment_date_factory = $request->revised_commitment_date_factory;
        $production->material_readiness = $request->material_readiness;
        $production->completion_status = $request->status_of_completion;
        $production->no_of_days = $request->no_of_days;
        $production->dispatch_date = $request->dispatch_date;
        $production->specification = $request->specification;
        $production->issue = $request->issue;
        $production->address = $request->address_details;
        $production->save();

        if (isset($request->stage_of_material) && count($request->stage_of_material) > 0){
            ProductionSom::where('prod_id', $id)->delete();
            foreach ($request->stage_of_material as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'som_id' => $request->stage_of_material[$key],
                    'note' => $request->stage_of_material_note[$key] ?? null,
                ];
                ProductionSom::create($data);
            }
        }

        if (isset($request->manufacturing_by) && count($request->manufacturing_by) > 0){
            ProductionMnfStage::where('prod_id', $id)->delete();
            foreach ($request->manufacturing_by as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'ms_id' => $request->manufacturing_stage[$key],
                    'status' => $request->manufacturing_status[$key],
                    'production_date' => $request->production_date[$key],
                    'readiness_date' => $request->readiness_date[$key],
                    'mf_by' => $request->manufacturing_by[$key],
                ];
                ProductionMnfStage::create($data);
            }
        }
        Flash::success('Updated Successfully');
        return redirect(url('manufacture_production'));
    }

    public function delete($id)
    {
        $data = Production::whereId($id)->first();
        if (empty($data)){
            Flash::error('Not Found');
            return redirect(url('manufacture_production'));
        }
        ProductionSom::where('prod_id', $id)->delete();
        ProductionMnfStage::where('prod_id', $id)->delete();
        Production::whereId($id)->delete();

        Flash::success('Deleted Successfully');

        return redirect(url('manufacture_production'));
    }

    public function import(Request $request)
    {

        $request->validate([
            'import_file' =>[
                'required',
                'mimes:xlsx,xls',
            ],
        ]);

        if (empty($request)){
            Flash::error('Not Found');
            return redirect(url('manufacture_production'));
        }
        Excel::import(new ManufactureProductionImport, $request->file('import_file'));
        Flash::success('imported Successfully');
        return redirect(url('manufacture_production'));
    }

    public function export()
    {
        $filename ="manufactureproduction.xlsx";
        return Excel::download(new ManufactureProductionExport, $filename);
        Flash::success('exported Successfully');
        return redirect(url('manufacture_production'));
    }

    public function importExportView()
    {
        return view('manufacture_production.importManufactureDispatch');
    }
}
