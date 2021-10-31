<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateExperience;
use EncryptDecrypt;
use App\Experience;
use App\ExperienceImage;
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
        $columns = array(6 => 'created_at', 1 => 'title', 7 => 'updated_at');
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
                // $nestedData[] = ($key->image ? '<img src="/images/experience/logo/'.$key->image.'" alt="'.$key->title.'" style="width: 100px;"></img>' : 'NA');
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
        $experince = Experience::select('id', 'title', 'info', 'details', 'image', 'original_image_name', 'country_id', 'state_id', 'city_id', 'created_at', 'updated_at')->with('experience_images')->where('id', $id)->first();
        if($experince)
            return response()->json(['success'=>true, 'msg' => 'Experince found.', 'data' => $experince], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching experince.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateExperience::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $experienceCreated = Experience::create(['title' => $input['title'], 'info' => $input['info'], 'details' => $input['details'], 'image' => 'NA', 'original_image_name' => 'NA', 'country_id' => $input['country_id'], 'state_id' => $input['state_id'], 'city_id' => $input['city_id']]);
        if($experienceCreated){
            $data = array();
            if ($request->has('image') && $request->file('image')) {
                $images=array();
                $files = $request->file('image');
                $i = 0;
                foreach($files as $file){
                    $name = uniqid().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/images/experience/logo');
                    $file->move($destinationPath, $name);
                    $images[$i]['original_image_name'] = $file->getClientOriginalName();
                    $images[$i]['image'] = $name;
                    $images[$i]['experience_id'] = $experienceCreated->id;
                    $images[$i]['created_at'] = Carbon::now();
                    $images[$i]['updated_at'] = Carbon::now();
                    $i++;
                }
                $data = $images;
            }
            $insertExperienceImages = ExperienceImage::insert($data);
            if($insertExperienceImages)
                return response()->json(['success'=>true, 'msg' => 'Experience is successfully created.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error creating experience images.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error creating experience.' ],500);
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
                $experienceUpdated = Experience::where('id', $mainid)->update(['title' => $input['title'], 'info' => $input['info'], 'details' => $input['details'], 'country_id' => $input['country_id'], 'state_id' => $input['state_id'], 'city_id' => $input['city_id']]);
                if($experienceUpdated){
                    $data = array();
                    if ($request->has('image') && $request->file('image')) {
                        $images=array();
                        $files = $request->file('image');
                        $i = 0;
                        foreach($files as $file){
                            $name = uniqid().'.'.$file->getClientOriginalExtension();
                            $destinationPath = public_path('/images/experience/logo');
                            $file->move($destinationPath, $name);
                            $images[$i]['original_image_name'] = $file->getClientOriginalName();
                            $images[$i]['image'] = $name;
                            $images[$i]['experience_id'] = $mainid;
                            $images[$i]['created_at'] = Carbon::now();
                            $images[$i]['updated_at'] = Carbon::now();
                            $i++;
                        }
                        $data = $images;
                    }
                    $insertExperienceImages = ExperienceImage::insert($data);
                    if($insertExperienceImages)
                        return response()->json(['success'=>true, 'msg' => 'Experience is successfully updated.'], $this->successStatus);
                    else return response()->json(['success'=>false, 'msg' => 'Error updating Experience images.' ],500);
                } else return response()->json(['success'=>false, 'msg' => 'Error updating Experience.' ],500);
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

    public function deleteImage(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateExperience::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $experienceCheck = ExperienceImage::where('id', $id)->first();
        if($experienceCheck){
            $deleted = $experienceCheck->destroy($id);
            if($deleted){
                $destinationPath = public_path('/images/experience/logo');
                if(file_exists($destinationPath.'/'.$experienceCheck->image))
                    File::delete($destinationPath.'/'.$experienceCheck->image);
                return response()->json(['success'=>true, 'msg' => 'Experience Image is successfully deleted.'], $this->successStatus);
            }else return response()->json(['success'=>false, 'msg' => 'Error deleting experience image.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting experience image.' ],404);
    }
}
