<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateExperience;
use EncryptDecrypt;
use App\Experience;
use App\Country;
use App\State;
use App\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ExperienceController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request) {
        $requestData = $request; 
        $columns = array(4 => 'created_at', 2 => 'title', 5 => 'updated_at');
        $search = $requestData['search']['value'];
        $data = array();
        if($search != ""){
            $totalData = Experience::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->count();
            $totalFiltered = $totalData;
            $magazines = Experience::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }else {
            $totalData = Experience::count();
            $totalFiltered = $totalData;
            $magazines = Experience::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }
        $totalFiltered = sizeof($magazines);
        if($magazines && sizeof($magazines) > 0){
            $i = $requestData['start'];
            foreach($magazines as $key){
                $nestedData = array();
                $encryptedId = EncryptDecrypt::encrypt($key->id);
                $nestedData[] = $i+1;
                $nestedData[] = ($key->image ? '<img src="/images/experience/logo/'.$key->image.'" alt="'.$key->title.'" style="width: 100px;"></img>' : 'NA');
                $nestedData[] = ($key->title ? $key->title : 'NA');
                $nestedData[] = ($key->info ? $key->info : 'NA');
                $nestedData[] = ($key->country_id ? Country::where('id', $key->country_id)->value('name') : 'NA');
                $nestedData[] = ($key->state_id ? State::where('id', $key->state_id)->value('name') : 'NA');
                $nestedData[] = ($key->city_id ? City::where('id', $key->city_id)->value('name') : 'NA');
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
                $nestedData[] = '<a href="/v1/experience/'.$encryptedId.'"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteExperience(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
                $data[] = $nestedData;
                ++$i;
            }
        }
        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data  
        );
        echo json_encode($json_data);
    }

    public function show(Request $request) {
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateExperience::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $experince = Experience::select('title', 'info', 'details', 'image', 'original_image_name', 'country_id', 'state_id', 'city_id', 'created_at', 'updated_at')->where('id', $id)->first();
        if($experince)
            return response()->json(['success'=>true, 'msg' => 'Experince found.', 'data' => $experince], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching experince.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateExperience::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/experience/logo');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $input['image'] = $name;
            $input['original_image_name'] = $image->getClientOriginalName();
        }
        $experienceCreated = Experience::create($input);
        if($experienceCreated)
            return response()->json(['success'=>true, 'msg' => 'Experience is successfully saved.'], $this->successStatus);
        else
            return response()->json(['success'=>false, 'msg' => 'Error creating experience.' ],500);
    }

    public function update(Request $request){
        $id = $request->input('id');
        if($id){
            $mainid = EncryptDecrypt::decrypt($id);
            $experienceCheck = Experience::where('id', $mainid)->first();
            if($experienceCheck){
                $input = $request->all();
                $validation = ValidateExperience::update($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $name = uniqid().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/experience/logo');
                    $imagePath = $destinationPath. "/".  $name;
                    $image->move($destinationPath, $name);
                    $input['image'] = $name;
                    $input['original_image_name'] = $image->getClientOriginalName();
                }
                unset($input["id"]);
                $experienceUpdated = Experience::where('id', $mainid)->update($input);
                if($experienceUpdated){
                    $destinationPath = public_path('/images/experience/logo');
                    if($request->hasFile('image') && file_exists($destinationPath.'/'.$experienceCheck->image))
                        File::delete($destinationPath.'/'.$experienceCheck->image);
                    return response()->json(['success'=>true, 'msg' => 'Experience is successfully updated.'], $this->successStatus);
                } else return response()->json(['success'=>false, 'msg' => 'Error creating experience.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Experience not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function delete(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateExperience::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $experienceCheck = Experience::where('id', $id)->first();
        if($experienceCheck){
            $deleted = $experienceCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Experience is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting experience.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting experience.' ],404);
    }
}
