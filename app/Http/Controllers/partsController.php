<?php

namespace App\Http\Controllers;

use App\DataTables\partsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatepartsRequest;
use App\Http\Requests\UpdatepartsRequest;
use App\Models\parts;
use App\Models\activity;
use App\Models\partDetails;
use App\Repositories\partsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class partsController extends AppBaseController
{
    /** @var  partsRepository */
    private $partsRepository;

    public function __construct(partsRepository $partsRepo)
    {
        $this->middleware('auth');
        $this->partsRepository = $partsRepo;
    }

    /**
     * Display a listing of the parts.
     *
     * @param partsDataTable $partsDataTable
     * @return Response
     */
    public function index(partsDataTable $partsDataTable)
    {
        return $partsDataTable->render('parts.index');
    }

    /**
     * Show the form for creating a new parts.
     *
     * @return Response
     */
    public function create()
    {
        return view('parts.create');
    }

    /**
     * Store a newly created parts in storage.
     *
     * @param CreatepartsRequest $request
     *
     * @return Response
     */
    public function store(CreatepartsRequest $request)
    {
        $input = $request->all();

        $parts = $this->partsRepository->create($input);
        if(!empty($request['input_description'])){
            for($i = 0; $i<count($request['input_description']); $i++){
                if($request['input_description'][$i] != ''){
                    $person = [];
                    $person['part_id'] = $parts->id;
                    $person['description'] = $request['input_description'][$i];
                    $person['price'] = $request['input_price'][$i];
                    $person['gst'] = $request['gst'][$i];
                    partDetails::create($person);
                }

            }
        }
        $entry['t_name'] = "Parts";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Parts saved successfully',
            'alert-type' => 'success'
        );


        return redirect(route('parts.index'))->with($notification);
    }

    /**
     * Display the specified parts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parts = $this->partsRepository->find($id);

        if (empty($parts)) {
            $notification = array(
                'message' => 'Parts not found',
                'alert-type' => 'error'
            );

            return redirect(route('parts.index'))->with($notification);
        }
        $persons = partDetails::where('part_id',$id)->where('is_deleted','0')->get();
        return view('parts.show',compact('persons'))->with('parts', $parts);
    }

    /**
     * Show the form for editing the specified parts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parts = $this->partsRepository->find($id);

        if (empty($parts)) {
            $notification = array(
                'message' => 'Parts not found',
                'alert-type' => 'error'
            );

            return redirect(route('parts.index'))->with($notification);
        }
        $persons = partDetails::where('part_id',$id)->where('is_deleted','0')->get();

        return view('parts.edit',compact('persons'))->with('parts', $parts);
    }

    /**
     * Update the specified parts in storage.
     *
     * @param  int              $id
     * @param UpdatepartsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepartsRequest $request)
    {
        $parts = $this->partsRepository->find($id);

        if (empty($parts)) {
            $notification = array(
                'message' => 'Parts not found',
                'alert-type' => 'error'
            );

            return redirect(route('parts.index'))->with($notification);
        }

        $parts = $this->partsRepository->update($request->all(), $id);

        if(!empty($request['input_description'])) {
            for ($i = 0; $i < count($request['input_description']); $i++) {
                if ($request['input_description'][$i] != '') {
                    $person = [];
                    $person['part_id'] = $parts->id;
                    $person['description'] = $request['input_description'][$i];
                    $person['price'] = $request['input_price'][$i];
                    $person['gst'] = $request['gst'][$i];
//                    partDetails::create($person);
                    if (isset($request['authorized_id'][$i])) {
                        if (partDetails::where('id', $request['authorized_id'][$i])->exists()) {
                            partDetails::where('id', $request['authorized_id'][$i])->update($person);
                        } else {
                            partDetails::create($person);
                        }
                    } else {
                        partDetails::create($person);
                    }
                }

            }

        }
        $entry['t_name'] = "Parts";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Parts updated successfully',
            'alert-type' => 'success'
        );

        return redirect(route('parts.index'))->with($notification);
    }

    /**
     * Remove the specified parts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parts = $this->partsRepository->find($id);

        if (empty($parts)) {
            $notification = array(
                'message' => 'Parts not found',
                'alert-type' => 'error'
            );

            return redirect(route('parts.index'))->with($notification);
        }

//        $this->partsRepository->delete($id);
        parts::where('id',$id)->update(['is_deleted'=>1]);
        partDetails::where('part_id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "Parts";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Parts deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('parts.index'))->with($notification);
    }
}
