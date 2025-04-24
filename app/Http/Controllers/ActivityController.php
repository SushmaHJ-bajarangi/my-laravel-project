<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activity;
use App\User;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activity = activity::get();
        $users = User::get();
        return view('activity.index',compact('activity','users'));
    }

    public function filter(Request $request)
    {
        if ($request->change_by == "All")
        {
            $filter_data = activity::get();
        }
        else
        {
            $filter_data = activity::where('change_by', $request->change_by)->get();
        }
        return response()->json($filter_data);
    }
}