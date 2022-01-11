<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateActivity;
use EncryptDecrypt;
use App\Activity;
use App\ActivityImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ActivityController extends Controller
{
    public $successStatus = 200;
 
    // public function index(Request $request) {
    //     $requestData = $request; 
    //     $columns = array(3 => 'created_at', 1 => 'title', 4 => 'updated_at');
    //     $search = $requestData['search']['value'];
    //     $data = array();
    //     if($search != ""){
    //         $totalData = Activity::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->count();
    //         $totalFiltered = $totalData;
    //         $magazines = Activity::where('title','LIKE',"%{$search}%")->orWhere('details','LIKE',"%{$search}%")->orWhere('info','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }else {
    //         $totalData = Activity::count();
    //         $totalFiltered = $totalData;
    //         $magazines = Activity::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }
    //     $totalFiltered = sizeof($magazines);
    //     if($magazines && sizeof($magazines) > 0){
    //         $i = $requestData['start'];
    //         foreach($magazines as $key){
    //             $nestedData = array();
    //             $encryptedId = EncryptDecrypt::encrypt($key->id);
    //             $nestedData[] = $i+1;
    //             // $nestedData[] = ($key->image ? '<img src="/images/activity/logo/'.$key->image.'" alt="'.$key->title.'" style="width: 100px;"></img>' : 'NA');
    //             $nestedData[] = ($key->title ? $key->title : 'NA');
    //             $nestedData[] = ($key->info ? $key->info : 'NA');
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
    //             $nestedData[] = '<a href="/v1/activity/'.$encryptedId.'"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteActivity(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
    //             $data[] = $nestedData;
    //             ++$i;
    //         }
    //     }
    //     $json_data = array(
    //         "draw" => intval($request['draw']), 
    //         "recordsTotal" => intval($totalData), 
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data  
    //     );
    //     echo json_encode($json_data);
    // }

    public function index(){
        $activities=Activity::all();
        if($activities){
            return response()->json(['success'=>true,'msg' => 'Activity found.', 'data' => $activities],200);
        }
        return response()->json(['error'=>true,'msg' => 'Activity not found.'],404);
    }

    public function show(Request $request) {
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        
        $activity = Activity::select('id', 'title', 'info', 'details', 'image', 'original_image_name', 'created_at', 'updated_at')->with('activity_images')->where('id', $id)->first();
        if($activity)
            return response()->json(['success'=>true, 'msg' => 'Activity found.', 'data' => $activity], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching activity.' ],500);
    }

    public function store(Request $request){
       $input = $request->all();
        $validation = ValidateActivity::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $activityCreated = Activity::create(['title' => $input['title'], 'info' => $input['info'], 'details' => $input['details'], 'image' => 'NA', 'original_image_name' => 'NA']);
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
                    $images[$i]['activity_id'] = $activityCreated->id;
                    $images[$i]['created_at'] = Carbon::now();
                    $images[$i]['updated_at'] = Carbon::now();
                    $i++;
                }
                $data = $images;
            }
            $insertActivityImages = ActivityImage::insert($data);
            if($insertActivityImages)
                return response()->json(['success'=>true, 'msg' => 'Activity is successfully created.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error creating activity images.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error creating activity.' ],500);
       
    }

    public function update(Request $request){
        $id = $request->input('id');
        if($id){
            //$mainid = EncryptDecrypt::decrypt($id);
            $mainid = $id;
            $activityCheck = Activity::where('id', $mainid)->first();
            if($activityCheck){
                $input = $request->all();
                $validation = ValidateActivity::update($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                $activityUpdated = Activity::where('id', $mainid)->update(['title' => $input['title'], 'info' => $input['info'], 'details' => $input['details']]);
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
                            $images[$i]['activity_id'] = $mainid;
                            $images[$i]['created_at'] = Carbon::now();
                            $images[$i]['updated_at'] = Carbon::now();
                            $i++;
                        }
                        $data = $images;
                    }
                    $insertActivityImages = ActivityImage::insert($data);
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

    public function deleteImage(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateActivity::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $activityCheck = ActivityImage::where('id', $id)->first();
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
