<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\City;

class CountryStateCityController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request) {
        $countries = Country::get();
        if($countries)
            return response()->json(['success'=>true, 'msg' => 'Countries found.', 'data' => $countries], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching countries.' ],500);
    }

    public function states(Request $request) {
        if($request->has('country_id') && $request->input('country_id')){
            $countryId = $request->input('country_id');
            $checkCountryCount = Country::where('id', $countryId)->count();
            if($checkCountryCount){
                $states = State::where('country_id', $countryId)->get();
                if($states)
                    return response()->json(['success'=>true, 'msg' => 'States found.', 'data' => $states], $this->successStatus);
                else return response()->json(['success'=>false, 'msg' => 'Error fetching states.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Country not found' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received' ],403);
    }

    public function cities(Request $request) {
        if($request->has('state_id') && $request->input('state_id')){
            $stateId = $request->input('state_id');
            $checkStateCount = State::where('id', $stateId)->count();
            if($checkStateCount){
                $cities = City::where('state_id', $stateId)->get();
                if($cities)
                    return response()->json(['success'=>true, 'msg' => 'Cities found.', 'data' => $cities], $this->successStatus);
                else return response()->json(['success'=>false, 'msg' => 'Error fetching cities.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'State not found' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received' ],403);
    }
}
