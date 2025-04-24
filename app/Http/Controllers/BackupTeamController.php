<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBackupTeamRequest;
use App\Http\Requests\UpdateBackupTeamRequest;
use App\Repositories\BackupTeamRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\BackupHelper;
use App\Models\BackupTeam;
use App\Models\activity;
use App\Models\Zone;


class BackupTeamController extends AppBaseController
{

    /** @var  BackupTeamRepository */
    private $backupTeamRepository;

    public function __construct(BackupTeamRepository $backupTeamRepo)
    {
        $this->middleware('auth');
        $this->backupTeamRepository = $backupTeamRepo;

    }

    /**
     * Display a listing of the BackupTeam.
     *
     * @param Request $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        $backupTeams = BackupTeam::where('is_deleted',0)->get();
        foreach ($backupTeams as $serviceTeam)
        {
            $zone=Zone::where('id',$serviceTeam->zone)->first();
            if(!empty($zone))
            {
                $serviceTeam['zonetitle']= $zone->title;
            }
            else{
                $serviceTeam['zonetitle']= 'No Zone';
            }

        }
        return view('backup_teams.index')
            ->with('backupTeams', $backupTeams);

    }

    /**
     * Show the form for creating a new BackupTeam.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|Response
     */
    public function create()
    {
        $customer_zones = Zone::where('is_deleted',0)->get();
        return view('backup_teams.create',compact('customer_zones'));
    }

    /**
     * Store a newly created BackupTeam in storage.
     *
     * @param CreateBackupTeamRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function store(CreateBackupTeamRequest $request)
    {
        $input = $request->all();

        $backupTeam = $this->backupTeamRepository->create($input);
        if(!empty($request['helper_name'])){
            for($i = 0; $i<count($request['helper_name']); $i++){
                if($request['helper_name'][$i] != ''){
                    $helpers = [];
                    $helpers['team_id'] = $backupTeam->id;
                    $helpers['name'] = $request['helper_name'][$i];
                    $helpers['number'] = $request['helper_contact_number'][$i];
                    BackupHelper::create($helpers);
                }
            }
        }

        $entry['t_name'] = "ServiceTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        Flash::success('Service Team Saved Successfully.');

        return redirect(route('backupTeams.index'));
    }

    /**
     * Display the specified BackupTeam.
     *
     * @param int $id
     *
     * @return Factory|RedirectResponse|Redirector|View|Response
     */
    public function show($id)
    {
        $backupTeam = $this->backupTeamRepository->find($id);

        if (empty($backupTeam)) {
            Flash::error('Service Team Not Found');

            return redirect(route('backupTeams.index'));
        }

        return view('backup_teams.show')->with('backupTeam', $backupTeam);
    }

    /**
     * Show the form for editing the specified BackupTeam.
     *
     * @param int $id
     *
     * @return Factory|RedirectResponse|Redirector|View|Response
     */
    public function edit($id)
    {
        $backupTeam = $this->backupTeamRepository->find($id);
        $customer_zones = Zone::where('is_deleted',0)->get();
        $helpers = BackupHelper::where('team_id',$id)->where('is_deleted',0)->get();
        if (empty($backupTeam)) {
            Flash::error('Service Team Not Found');

            return redirect(route('backupTeams.index'));
        }
        return view('backup_teams.edit',compact('helpers','customer_zones'))->with('backupTeam', $backupTeam);
    }

    /**
     * Update the specified BackupTeam in storage.
     *
     * @param int $id
     * @param UpdateBackupTeamRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function update($id, UpdateBackupTeamRequest $request)
    {
        $team = $this->backupTeamRepository->find($id);

        $backupTeam = $this->backupTeamRepository->find($id);

        if (empty($backupTeam)) {
            Flash::error('Service Team Not Found');

            return redirect(route('backupTeams.index'));
        }
        $backupTeam = $this->backupTeamRepository->update($request->all(), $id);
        if(!empty($request['helper_name'])){
            for($i = 0; $i<count($request['helper_name']); $i++){
                if($request['helper_name'][$i] != '') {
                    $helpers = [];
                    $helpers['team_id'] = $team->id;
                    $helpers['name'] = $request['helper_name'][$i];
                    $helpers['number'] = $request['helper_contact_number'][$i];
                    if (isset($request['helper_id'][$i])) {
                        if (BackupHelper::where('id', $request['helper_id'][$i])->exists()) {
                            BackupHelper::where('id', $request['helper_id'][$i])->update($helpers);
                        } else {
                            BackupHelper::create($helpers);
                        }
                    } else {
                        BackupHelper::create($helpers);
                    }
                }
            }
        }

        $entry['t_name'] = "ServiceTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        Flash::success('Service Team Updated Successfully.');
        return redirect(route('backupTeams.index'));
    }

    /**
     * Remove the specified BackupTeam from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function destroy($id)
    {
        $backupTeam = $this->backupTeamRepository->find($id);

        if (empty($backupTeam)) {
            Flash::error('Service Team Not Found');

            return redirect(route('backupTeams.index'));
        }
        BackupTeam::where('id',$id)->update(['is_deleted'=>'1']);
        BackupHelper::where('team_id',$id)->update(['is_deleted'=>'1']);

//        $this->backupTeamRepository->delete($id);

        $entry['t_name'] = "ServiceTeam";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        Flash::success('Service Team Deleted Successfully.');

        return redirect(route('backupTeams.index'));
    }
    public function backUpcheckTeamNumber(Request $request){
        if(BackupTeam::where('contact_number',$request->contact_number)->where('id','!=',$request->team_id)->exists()){
            return 'number_exists';
        }
        else{
            return 'number_not_exists';
        }
    }

    public function backUpremoveHelper(Request $request){
        BackupHelper::where('id',$request->id)->update(['is_deleted'=>'1']);
        return 'success';
    }
}
