<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateActivity;
use EncryptDecrypt;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ActivityController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request) {
        $requestData = $request; 
        $columns = array(4 => 'created_at', 2 => 'title', 5 => 'updated_at');
        $search = $requestData['search']['value'];
        $data = array();
        if($search != ""){
            $totalData = Activity::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->count();
            $totalFiltered = $totalData;
            $magazines = Activity::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }else {
            $totalData = Activity::count();
            $totalFiltered = $totalData;
            $magazines = Activity::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }
        $totalFiltered = sizeof($magazines);
        if($magazines && sizeof($magazines) > 0){
            $i = $requestData['start'];
            foreach($magazines as $key){
                $nestedData = array();
                $encryptedId = EncryptDecrypt::encrypt($key->id);
                $nestedData[] = $i+1;
                $nestedData[] = ($key->image ? '<img src="/images/activity/logo/'.$key->image.'" alt="'.$key->title.'" style="width: 100px;"></img>' : 'NA');
                $nestedData[] = ($key->title ? $key->title : 'NA');
                $nestedData[] = ($key->info ? $key->info : 'NA');
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
                $nestedData[] = '<a href="/v1/activity/'.$encryptedId.'"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteActivity(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
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
        $validation = ValidateActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $activity = Activity::select('title', 'info', 'details', 'image', 'original_image_name', 'created_at', 'updated_at')->where('id', $id)->first();
        if($activity)
            return response()->json(['success'=>true, 'msg' => 'Activity found.', 'data' => $activity], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching activity.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateActivity::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/activity/logo');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $input['image'] = $name;
            $input['original_image_name'] = $image->getClientOriginalName();
        }
        $activityCreated = Activity::create($input);
        if($activityCreated)
            return response()->json(['success'=>true, 'msg' => 'Activity is successfully saved.'], $this->successStatus);
        else
            return response()->json(['success'=>false, 'msg' => 'Error creating activity.' ],500);
    }

    public function update(Request $request){
        $id = $request->input('id');
        if($id){
            $mainid = EncryptDecrypt::decrypt($id);
            $activityCheck = Activity::where('id', $mainid)->first();
            if($activityCheck){
                $input = $request->all();
                $validation = ValidateActivity::update($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $name = uniqid().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/activity/logo');
                    $imagePath = $destinationPath. "/".  $name;
                    $image->move($destinationPath, $name);
                    $input['image'] = $name;
                    $input['original_image_name'] = $image->getClientOriginalName();
                }
                unset($input["id"]);
                $activityUpdated = Activity::where('id', $mainid)->update($input);
                if($activityUpdated){
                    $destinationPath = public_path('/images/activity/logo');
                    if($request->hasFile('image') && file_exists($destinationPath.'/'.$activityCheck->image))
                        File::delete($destinationPath.'/'.$activityCheck->image);
                    return response()->json(['success'=>true, 'msg' => 'Activity is successfully updated.'], $this->successStatus);
                } else return response()->json(['success'=>false, 'msg' => 'Error creating activity.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Activity not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function delete(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $activityCheck = Activity::where('id', $id)->first();
        if($activityCheck){
            $deleted = $activityCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Activity is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting activity.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting activity.' ],404);
    }
}
