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
}
