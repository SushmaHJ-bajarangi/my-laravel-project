<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\activity;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Apilogin(Request $request)
    {
       $data['success'] = true;
       $data['code'] = 200;
       $data['data'] = $_POST['email'];
       return $data;
    }

    public function adduser(){
        return view('adduser.create');
    }

    public function listUsers(){
        $list = User::where('is_deleted',0)->where('role',0)->get();
        return view('adduser.index',compact('list'));
    }

    public function storeUser(Request $request){

        $input['name']=$request->name;
        $input['email']=$request->email;
        $input['password']= Hash::make($request->password);
        $input['password_confirmation']=$request->password_confirmation;
        $input['role']=$request->role;
        User::create($input);
        if($request->password == $request->password_confirmation) {
            $entry['t_name'] = "User";
            $entry['change_by'] = Auth::user()->name;
            $entry['activity'] = "Inserted";
            activity::create($entry);
            $notification = array(
                'message' => 'User saved successfully',
                'alert-type' => 'success'
            );
            return redirect(url('listUser'))->with($notification);
        }

        $entry['t_name'] = "User";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'User saved successfully',
            'alert-type' => 'success'
        );

        return redirect(url('listUser'))->with($notification);
    }
    
    public function editUser($id){
        $edit_user = User::find($id);
    return view('adduser.edit',compact('edit_user'));
    }

    public function update(Request $request,$id){
        $user = User::where('id',$id)->first();
        if ($id != $user->id) {
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'warning'
            );
            return redirect(url('listUser'))->with($notification);
        }
        $update = ['name' => $request->name, 'email' => $request->email,'password'=>Hash::make($request->password),'role'=>$request->role];
        User::where('id',$id)->update($update);

        $entry['t_name'] = "User";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Users updated successfully.',
            'alert-type' => 'success'
        );
        return redirect(url('listUser'))->with($notification);
    }

    public function destory($id){
        User::where('id', $id)->update(['is_deleted' => '1']);

        $entry['t_name'] = "User";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
