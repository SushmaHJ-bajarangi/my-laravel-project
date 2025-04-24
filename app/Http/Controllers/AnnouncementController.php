<?php

namespace App\Http\Controllers;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Models\customers;
use App\Models\activity;
use App\Repositories\AnnouncementRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\team;
use Edujugon\PushNotification\PushNotification;
class AnnouncementController extends AppBaseController
{
    /** @var  AnnouncementRepository */
    private $announcementRepository;

    public function __construct(AnnouncementRepository $announcementRepo)
    {
        $this->middleware('auth');
        $this->announcementRepository = $announcementRepo;
    }

    /**
     * Display a listing of the Announcement.
     *
     * @param AnnouncementDataTable $announcementDataTable
     * @return Response
     */
    public function index(AnnouncementDataTable $announcementDataTable)
    {
        return $announcementDataTable->render('announcements.index');
    }

    /**
     * Show the form for creating a new Announcement.
     *
     * @return Response
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created Announcement in storage.
     *
     * @param CreateAnnouncementRequest $request
     *
     * @return Response
     */
    public function store(CreateAnnouncementRequest $request)
    {
        $input = $request->all();

        $input = $request->except('image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['image'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/announce');
            $image->move($destinationPath, $input['image']);
        }
        $input['technician'] = $request->technician;
        $input['date'] =date('d-m-Y');
        $announcement = $this->announcementRepository->create($input);

        if($input['technician']=='Technician')
        {
            $team=team::where('is_deleted',0)->get();
            foreach ($team as $item)
            {
                $device_token=$item['device_token'];
                $token[]=$device_token;

            }
            if($request->image == null)
            {
                $url='https://bajarangisoft.com/Teknix/public/images/logo.png';
            }
            else{
                $url='https://bajarangisoft.com/Teknix/public/announce/'.$input['image'];
            }
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => 'Hello dear Technician this Announcement from Teknix Elevators PVT LTD !!' ,
                    'body' => $input['description'],
                    'image'=>$url,
                    'sound' => 'default',
                    "content_available"=> true,
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",

                ],
                'data' => [
                    'data_notification' => "tech_announcement",


                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($token)
                ->send();
            $push->getFeedback();
        }
        else
        {
            $customer=customers::where('is_deleted',0)->get();
            foreach ($customer as $item)
            {
                $device_token=$item['device_token'];
                $token[]=$device_token;

            }
            if($request->image == null)
            {
                $url='https://bajarangisoft.com/Teknix/public/images/logo.png';
            }
            else{
                $url='https://bajarangisoft.com/Teknix/public/announce/'.$input['image'];
            }
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => 'Hello dear Customer this Announcement from Teknix Elevators PVT LTD !!' ,
                    'body' => $input['description'],
                    'image'=>$url,
                    'sound' => 'default',
                    "content_available"=> true,
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",

                ],
                'data' => [
                    'data_notification' => "customer_announcement",


                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($token)
                ->send();
            $push->getFeedback();
        }
        $entry['t_name'] = "Announcement";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Announcement created successfully',
            'alert-type' => 'success'
        );
        return redirect(route('announcements.index'))->with($notification);
    }

    /**
     * Display the specified Announcement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
           $notification = array('message'=>'announcements not found',
               'alert-type'=>'error'
               );
            return redirect(route('announcements.index'))->with($notification);
        }

        return view('announcements.show')->with('announcement', $announcement);
    }

    /**
     * Show the form for editing the specified Announcement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
            $notification = array('message'=>'announcements not found',
                'alert-type'=>'error'
            );

            return redirect(route('announcements.index'))->with($notification);
        }

        return view('announcements.edit')->with('announcement', $announcement);
    }

    /**
     * Update the specified Announcement in storage.
     *
     * @param  int              $id
     * @param UpdateAnnouncementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnnouncementRequest $request)
    {

        $announcement = $this->announcementRepository->find($id);
        if (empty($announcement)) {
            $notification = array('message'=>'announcements not found',
                'alert-type'=>'error'
            );

            return redirect(route('announcements.index'))->with($notification);
        }
        $input=$request->except('image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['image'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/announce');
            $image->move($destinationPath, $input['image']);
        }
        $input['technician'] = $request->technician;
        $announcements = $this->announcementRepository->update($input, $id);

        $entry['t_name'] = "Announcement";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'announcement updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('announcements.index'))->with($notification);
    }
    /**
     * Remove the specified Announcement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
            $notification = array('message'=>'announcements not found',
                'alert-type'=>'error'
            );

            return redirect(route('announcements.index'))->with($notification);
        }

//        $this->announcementRepository->delete($id);
        Announcement::where('id',$id)->update(['is_deleted'=>1]);

        $notification = array('message'=>'announcement deleted',
            'alert-type'=>'error'
        );

        $entry['t_name'] = "Announcement";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        return redirect(route('announcements.index'))->with($notification);
    }
}
