<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateVendorActivity;
use EncryptDecrypt;
use App\VendorActivity;
use App\Activity;
use App\User;
use App\VendorActivityImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
// use Auth;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request) {
        $requestData = $request; 
        $columns = array(5 => 'created_at', 6 => 'updated_at');
        $search = $requestData['search']['value'];
        $search = filter_var($search, FILTER_SANITIZE_STRING);
        $data = array();
        if($search != ""){
            $totalData = VendorActivity::whereJsonContains('days',"%{$search}%")->orWhere('info','LIKE', "%{$search}%")->count();
            $totalFiltered = $totalData;
            $magazines = VendorActivity::whereJsonContains('days',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }else {
            $totalData = VendorActivity::count();
            $totalFiltered = $totalData;
            $magazines = VendorActivity::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }
        $totalFiltered = sizeof($magazines);
        if($magazines && sizeof($magazines) > 0){
            $i = $requestData['start'];
            foreach($magazines as $key){
                $nestedData = array();
                $encryptedId = EncryptDecrypt::encrypt($key->id);
                $nestedData[] = $i+1;
                $nestedData[] =($key->activity_id ? Activity::where('id', $key->activity_id)->value('title') : 'NA');
                $nestedData[] = ($key->days ? json_decode($key->days) : 'NA');
                $nestedData[] = ($key->start_time ? date('H:i A', strtotime($key->start_time)) : 'NA');
                $nestedData[] = ($key->end_time ? date('H:i A', strtotime($key->end_time)) : 'NA');
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
                $nestedData[] = '<a href="/v2/activity/'.$encryptedId.'"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteActivity(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
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
        $validation = ValidateVendorActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $activity = VendorActivity::with('vendor_activity_images')->where('id', $id)->first();
        if($activity)
            return response()->json(['success'=>true, 'msg' => 'Activity found.', 'data' => $activity], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching activity.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateVendorActivity::store($input);
        $input['vendor_id'] = 1;
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $activityCreated = VendorActivity::create($input);
        if($activityCreated){
            $data = array();
            if ($request->has('image') && $request->file('image')) {
                $images=array();
                $files = $request->file('image');
                $i = 0;
                foreach($files as $file){
                    $name = uniqid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/images/activity/logo');
                    $file->move($destinationPath, $name);
                    $images[$i]['original_image_name'] = $file->getClientOriginalName();
                    $images[$i]['image'] = $name;
                    $images[$i]['vendor_activity_id'] = $activityCreated->id;
                    $images[$i]['created_at'] = Carbon::now();
                    $images[$i]['updated_at'] = Carbon::now();
                    $i++;
                }
                $data = $images;
            }
            $insertActivityImages = VendorActivityImage::insert($data);
            if($insertActivityImages)
                return response()->json(['success'=>true, 'msg' => 'Activity is successfully created.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error creating activity images.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error creating activity.' ],500);
       
    }

    public function update(Request $request){
        $id = $request->input('id');
        if($id){
            $mainid = EncryptDecrypt::decrypt($id);
            $activityCheck = VendorActivity::where('id', $mainid)->first();
            if($activityCheck){
                $input = $request->all();
                $validation = ValidateVendorActivity::update($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                $activityUpdated = VendorActivity::where('id', $mainid)->update(['activity_id' => $input['activity_id'], 'info' => $input['info'], 'days' => $input['days'], 'inclusives' => $input['inclusives'], 'exclusives' => $input['exclusives'], 'start_time' => $input['start_time'], 'end_time' => $input['end_time']]);
                if($activityUpdated){
                    $data = array();
                    if ($request->has('image') && $request->file('image')) {
                        $images=array();
                        $files = $request->file('image');
                        $i = 0;
                        foreach($files as $file){
                            $name = uniqid().'.'.$file->getClientOriginalExtension();
                            $destinationPath = public_path('/images/activity/logo');
                            $file->move($destinationPath, $name);
                            $images[$i]['original_image_name'] = $file->getClientOriginalName();
                            $images[$i]['image'] = $name;
                            $images[$i]['vendor_activity_id'] = $mainid;
                            $images[$i]['created_at'] = Carbon::now();
                            $images[$i]['updated_at'] = Carbon::now();
                            $i++;
                        }
                        $data = $images;
                    }
                    $insertActivityImages = VendorActivityImage::insert($data);
                    if($insertActivityImages)
                        return response()->json(['success'=>true, 'msg' => 'Activity is successfully updated.'], $this->successStatus);
                    else return response()->json(['success'=>false, 'msg' => 'Error updating activity images.' ],500);
                } else return response()->json(['success'=>false, 'msg' => 'Error updating activity.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Activity not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function delete(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateVendorActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $activityCheck = VendorActivity::where('id', $id)->first();
        if($activityCheck){
            $deleted = $activityCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Activity is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting activity.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting activity.' ],404);
    }

    public function deleteImage(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateVendorActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $activityCheck = VendorActivityImage::where('id', $id)->first();
        if($activityCheck){
            $deleted = $activityCheck->destroy($id);
            if($deleted){
                $destinationPath = public_path('/images/activity/logo');
                if(file_exists($destinationPath.'/'.$activityCheck->image))
                    File::delete($destinationPath.'/'.$activityCheck->image);
                return response()->json(['success'=>true, 'msg' => 'Activity Image is successfully deleted.'], $this->successStatus);
            }else return response()->json(['success'=>false, 'msg' => 'Error deleting activity image.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting activity image.' ],404);
    }
}