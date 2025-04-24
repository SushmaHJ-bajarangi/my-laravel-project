<?php

namespace App\Http\Controllers;

use App\DataTables\teamDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateteamRequest;
use App\Http\Requests\UpdateteamRequest;
use App\Models\customers;
use App\Models\Helpers;
use App\Repositories\teamRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\team;
use App\Models\Zone;
use App\Models\activity;

class teamController extends AppBaseController
{
    /** @var  teamRepository */
    private $teamRepository;

    public function __construct(teamRepository $teamRepo)
    {
        $this->middleware('auth');
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the team.
     *
     * @param teamDataTable $teamDataTable
     * @return Response
     */
    public function index(teamDataTable $teamDataTable)
    {
        return $teamDataTable->render('teams.index');
    }

    /**
     * Show the form for creating a new team.
     *
     * @return Response
     */
    public function create()
    {
        $customer_zones = Zone::where('is_deleted',0)->get();
        return view('teams.create',compact('customer_zones'));
    }

    /**
     * Store a newly created team in storage.
     *
     * @param CreateteamRequest $request
     *
     * @return Response
     */
    public function store(CreateteamRequest $request)
    {

        $input = $request->all();

        $team = $this->teamRepository->create($input);

        if(!empty($request['helper_name'])){
            for($i = 0; $i<count($request['helper_name']); $i++){
                if($request['helper_name'][$i] != ''){
                    $helpers = [];
                    $helpers['team_id'] = $team->id;
                    $helpers['name'] = $request['helper_name'][$i];
                    $helpers['contact_number'] = $request['helper_contact_number'][$i];
                    Helpers::create($helpers);
                }
            }
        }

        $entry['t_name'] = "TechnicianTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician Team Saved Successfully',
            'alert-type' => 'success'
        );

        return redirect(route('teams.index'))->with($notification);
    }

    /**
     * Display the specified team.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);

        $helpers = Helpers::where('team_id',$id)->where('is_deleted',0)->get();
        if (empty($team)) {
            $notification = array(
                'message' => 'Technician Team Not Found',
                'alert-type' => 'error'
            );
            return redirect(route('teams.index'))->with($notification);
        }
        return view('teams.show',compact('helpers'))->with('team', $team);
    }

    /**
     * Show the form for editing the specified team .
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $team = $this->teamRepository->find($id);
        $customer_zones = Zone::where('is_deleted',0)->get();
        $helpers = Helpers::where('team_id',$id)->where('is_deleted',0)->get();
        if (empty($team)) {
            $notification = array(
                'message' => 'Technician Team Not Found',
                'alert-type' => 'error'
            );

            return redirect(route('teams.index'))->with($notification);
        }
        return view('teams.edit',compact('helpers','customer_zones'))->with('team', $team);
    }

    /**
     * Update the specified team in storage.
     *
     * @param  int              $id
     * @param UpdateteamRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateteamRequest $request){
        $team = $this->teamRepository->find($id);
        if (empty($team)) {
            $notification = array(
                'message' => 'Technician Team Not Found',
                'alert-type' => 'error'
            );
            return redirect(route('teams.index'))->with($notification);
        }
        $team = $this->teamRepository->update($request->all(), $id);
        if(!empty($request['helper_name'])){
            for($i = 0; $i<count($request['helper_name']); $i++){
                if($request['helper_name'][$i] != '') {
                    $helpers = [];
                    $helpers['team_id'] = $team->id;
                    $helpers['name'] = $request['helper_name'][$i];
                    $helpers['contact_number'] = $request['helper_contact_number'][$i];
                    if (isset($request['helper_id'][$i])) {
                        if (Helpers::where('id', $request['helper_id'][$i])->exists()) {
                            Helpers::where('id', $request['helper_id'][$i])->update($helpers);
                        } else {
                            Helpers::create($helpers);
                        }
                    } else {
                        Helpers::create($helpers);
                    }
                }
            }
        }

        $entry['t_name'] = "TechnicianTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician Team Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect(route('teams.index'))->with($notification);
    }

    /**
     * Remove the specified team from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            $notification = array(
                'message' => 'Technician Team Not Found',
                'alert-type' => 'error'
            );

            return redirect(route('teams.index'))->with($notification);
        }

//        $this->teamRepository->delete($id);
        team::where('id',$id)->update(['is_deleted'=>'1']);
        Helpers::where('team_id',$id)->update(['is_deleted'=>'1']);

        $entry['t_name'] = "TechnicianTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician Team Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect(route('teams.index'))->with($notification);
    }

    public function checkTeamNumber(Request $request){
        if(team::where('contact_number',$request->contact_number)->where('id','!=',$request->team_id)->exists()){
            return 'number_exists';
        }
        else{
            return 'number_not_exists';
        }
    }

    public function removeHelper(Request $request){
        Helpers::where('id',$request->id)->update(['is_deleted'=>'1']);
        return 'success';
    }
}
