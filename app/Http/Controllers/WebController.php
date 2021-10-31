<?php

namespace App\Http\Controllers;
use App\Activity;
use App\Inclusive;
use App\Exclusive;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(Request $request, $id) {
        if($id == 0){
            return view('secondary.activity.add-edit-activity')->with(array('id' => $id));
        }else return view('secondary.activity.add-edit-activity')->with(array('id' => $id));
    }

    public function experience(Request $request, $id) {
        if($id == 0){
            return view('secondary.experience.add-edit-experience')->with(array('id' => $id));
        }else return view('secondary.experience.add-edit-experience')->with(array('id' => $id));
    }

    public function vendor(Request $request, $id) {
        if($id == 0){
            return view('secondary.vendor.add-edit-vendor')->with(array('id' => $id));
        }else return view('secondary.vendor.add-edit-vendor')->with(array('id' => $id));
    }

    public function vendor_activity(Request $request, $id) {
        $activities = Activity::select('id', 'title')->get();
        $inclusives = Inclusive::select('id', 'title')->get();
        $exclusives = Exclusive::select('id', 'title')->get();
        return view('secondary.v-portal.activity.add-edit')->with(array('id' => $id, 'activities' => $activities, 'inclusives' => $inclusives, 'exclusives' => $exclusives));
    }
}
