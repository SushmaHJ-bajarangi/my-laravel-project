<?php

namespace App\Http\Controllers;
use App\Models\Manufacture;
use App\Models\ManufactureCopLop;
use App\Models\ManufactureHarness;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Models\customers;
use App\Models\StageOfMaterial;
use App\Models\DispatchStatus;
use App\Models\Priority;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;


class ManufactureController extends Controller
{
    public function index(Request $request)
    {
        $data = Manufacture::get();
        return view('manufacture.index')
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
        return view('manufacture.create', compact('customer', 'stage_of_material','dispatch_status','priority','manufacture_production','manufacture_stages','manufacture_status'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'place' => 'required|string|max:255',
            'jobs' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'controller' => 'required|string|max:255',
            'controller_readiness_status' => 'required|string|max:255',
            'controller_readiness_date' => 'required|date',
            'comments' => 'nullable|string',
            'specification' => 'nullable|string',
            'issue' => 'nullable|string',
            'address' => 'nullable|string',

            'cop_lop' => 'nullable|array',
            'cop_lop.*' => 'nullable|string|max:255',

            'cop_lop_readiness_status' => 'nullable|array',
            'cop_lop_readiness_status.*' => 'nullable|string|max:255',

            'cop_lop_readiness_date' => 'nullable|array',

            'harness' => 'nullable|array',
            'harness.*' => 'nullable|string|max:255',
            'harness_readiness_status' => 'nullable|array',
            'harness_readiness_status.*' => 'nullable|string|max:255',
            'harness_readiness_date' => 'nullable|array',
        ]);


        $manufacture = Manufacture::create([
            'place' => $validatedData['place'],
            'jobs' => $validatedData['jobs'],
            'customer_name' => $validatedData['customer_name'],
            'controller' => $validatedData['controller'],
            'controller_readiness_status' => $validatedData['controller_readiness_status'],
            'controller_readiness_date' => $validatedData['controller_readiness_date'],
            'comments' => $validatedData['comments'],
            'specification' => $validatedData['specification'],
            'issue' => $validatedData['issue'],
            'address' => $validatedData['address'],
        ]);

        if (isset($validatedData['cop_lop']) && count($validatedData['cop_lop']) > 0) {
            foreach ($validatedData['cop_lop'] as $key => $item) {
                // Ensure that we have valid data for cop_lop_readiness_status and cop_lop_readiness_date
                ManufactureCopLop::create([
                    'manufactures_id' => $manufacture->id,
                    'cop_lop' => $item,
                    'cop_lop_readiness_status' => $validatedData['cop_lop_readiness_status'][$key] ?? 'Not Specified',
                    'cop_lop_readiness_date' => $validatedData['cop_lop_readiness_date'][$key] ?? now(),
                ]);
            }
        }

        if (isset($validatedData['harness']) && count($validatedData['harness']) > 0) {
            foreach ($validatedData['harness'] as $key => $item) {

                ManufactureHarness::create([
                    'manufactures_id' => $manufacture->id,
                    'harness' => $item,
                    'harness_readiness_status' => $validatedData['harness_readiness_status'][$key] ?? 'Not Specified',
                    'harness_readiness_date' => $validatedData['harness_readiness_date'][$key] ?? now(),
                ]);
            }
        }

        Flash::success('Saved Successfully.');
        return redirect('manufacture');

       dd($request->all());
     }


    public function edit($id)
    {
        $customer = customers::where('is_deleted', 0)->get();
        $data = Manufacture::findOrFail($id);
        $p_mns = ManufactureCopLop::where('manufactures_id', $id)->get(); // COP/LOP
        $p_som = ManufactureHarness::where('manufactures_id', $id)->get(); // Harness

        return view('manufacture.edit', compact('data', 'p_mns', 'p_som', 'customer'));
    }

    public function update($id, Request $request)
    {
        $manufacture = Manufacture::whereId($id)->first();

        if (empty($manufacture)) {
            Flash::error('Manufacture record not found');
            return redirect(url('manufacture'));
        }

        $manufacture->place = $request->place;
        $manufacture->jobs = $request->jobs;
        $manufacture->customer_name = $request->customer_name;
        $manufacture->controller = $request->controller;
        $manufacture->controller_readiness_status = $request->controller_readiness_status;
        $manufacture->controller_readiness_date = $request->controller_readiness_date;
        $manufacture->comments = $request->comments;
        $manufacture->specification = $request->specification;
        $manufacture->issue = $request->issue;
        $manufacture->address = $request->address;

        $manufacture->save();

        if (isset($request->cop_lop) && count($request->cop_lop) > 0) {

            ManufactureCopLop::where('manufactures_id', $id)->delete();


            foreach ($request->cop_lop as $key => $item) {
                $copLopData = [
                    'manufactures_id' => $manufacture->id,
                    'cop_lop' => $item,
                    'cop_lop_readiness_status' => $request->cop_lop_readiness_status[$key] ?? 'Not Specified',
                    'cop_lop_readiness_date' => $request->cop_lop_readiness_date[$key] ?? now(),
                ];
                ManufactureCopLop::create($copLopData);
            }
        }


        if (isset($request->harness) && count($request->harness) > 0) {

            ManufactureHarness::where('manufactures_id', $id)->delete();


            foreach ($request->harness as $key => $item) {
                $harnessData = [
                    'manufactures_id' => $manufacture->id,
                    'harness' => $item,
                    'harness_readiness_status' => $request->harness_readiness_status[$key] ?? 'Not Specified',
                    'harness_readiness_date' => $request->harness_readiness_date[$key] ?? now(),
                ];
                ManufactureHarness::create($harnessData);
            }
        }
        Flash::success('Manufacture record updated successfully');
        return redirect('manufacture');
    }

    public function delete($id)
    {
        $data = Manufacture::whereId($id)->first();
        if (empty($data)){
            Flash::error('Not Found');
            return redirect(url('manufacture'));
        }
        ManufactureCopLop::where('manufactures_id', $id)->delete();
        ManufactureHarness::where('manufactures_id', $id)->delete();
        Manufacture::whereId($id)->delete();

        Flash::success('Deleted Successfully');

        return redirect(url('manufacture'));
    }
}

