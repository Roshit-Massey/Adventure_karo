<?php

namespace App\Http\Controllers;

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
}
