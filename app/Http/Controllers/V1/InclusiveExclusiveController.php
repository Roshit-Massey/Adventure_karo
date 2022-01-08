<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateInclusive;
use ValidateExclusive;
use EncryptDecrypt;
use App\Inclusive;
use App\Exclusive;
use Carbon\Carbon;

class InclusiveExclusiveController extends Controller
{
    public $successStatus = 200;

    // public function index(Request $request) {
        
    //     $requestData = $request; 
    //     $columns = array(2 => 'created_at', 1 => 'title', 3 => 'updated_at');
    //     $search = $requestData['search']['value'];
    //     $data = array();
    //     if($search != ""){
    //         $totalData = Inclusive::where('title','LIKE',"%{$search}%")->count();
    //         $totalFiltered = $totalData;
    //         $magazines = Inclusive::where('title','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }else {
    //         $totalData = Inclusive::count();
    //         $totalFiltered = $totalData;
    //         $magazines = Inclusive::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }
    //     $totalFiltered = sizeof($magazines);
    //     if($magazines && sizeof($magazines) > 0){
    //         $i = $requestData['start'];
    //         foreach($magazines as $key){
    //             $nestedData = array();
    //             $encryptedId = EncryptDecrypt::encrypt($key->id);
    //             $nestedData[] = $i+1;
    //             $nestedData[] = ($key->title ? $key->title : 'NA');
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
    //             $nestedData[] = '<a href="javascript:void(0);" onclick="editInclusive(\''.$encryptedId.'\')"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteInclusive(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
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
        $inclisives=Inclusive::all();
        if($inclisives){
            return response()->json(['success'=>true,'msg' => 'Inclusive found.', 'data' => $inclisives],200);
        }
        return response()->json(['error'=>true,'msg' => 'Inclusive not found.'],404);
    }

    public function show(Request $request) {
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateInclusive::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        //$id = EncryptDecrypt::decrypt($id);
        $inclusive = Inclusive::select('title', 'status', 'created_at', 'updated_at')->where('id', $id)->first();
        if($inclusive)
            return response()->json(['success'=>true, 'msg' => 'Inclusive found.', 'data' => $inclusive], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching inclusive.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateInclusive::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $checkInclusive = Inclusive::where('title', $input['title'])->first();
        if(!$checkInclusive){
            $inclusiveCreated = Inclusive::create($input);
            if($inclusiveCreated) 
                return response()->json(['success'=>true, 'msg' => 'Inclusive is successfully saved.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error creating inclusive.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Inclusive name already exists' ],403);
    }

    public function update(Request $request){
         $input = $request->all();
         $id = $request->input('id');
        if($id){
           // $mainid = EncryptDecrypt::decrypt($id);
            $mainid = $id;
            $validation = ValidateInclusive::update($input);
            if($validation->fails())  
                return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
            $checkExist = Inclusive::where('title', $input['title'])->where('id', "!=", $mainid)->first();
            if(!$checkExist){
                unset($input["id"]);
                $inclusiveUpdated = Inclusive::where('id', $mainid)->update($input);
                if($inclusiveUpdated){
                    return response()->json(['success'=>true, 'msg' => 'Inclusive is successfully updated.'], $this->successStatus);
                } else return response()->json(['success'=>false, 'msg' => 'Error creating inclusive.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Inclusive name already exists' ],403);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function delete(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateInclusive::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        //$id = EncryptDecrypt::decrypt($id);
        $inclusiveCheck = Inclusive::where('id', $id)->first();
        if($inclusiveCheck){
            $deleted = $inclusiveCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Inclusive is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting inclusive.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting inclusive.' ],404);
    }
 
    // public function list(Request $request) {
    //     $requestData = $request; 
    //     $columns = array(2 => 'created_at', 1 => 'title', 3 => 'updated_at');
    //     $search = $requestData['search']['value'];
    //     $data = array();
    //     if($search != ""){
    //         $totalData = Exclusive::where('title','LIKE',"%{$search}%")->count();
    //         $totalFiltered = $totalData;
    //         $magazines = Exclusive::where('title','LIKE',"%{$search}%")->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }else {
    //         $totalData = Exclusive::count();
    //         $totalFiltered = $totalData;
    //         $magazines = Exclusive::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
    //     }
    //     $totalFiltered = sizeof($magazines);
    //     if($magazines && sizeof($magazines) > 0){
    //         $i = $requestData['start'];
    //         foreach($magazines as $key){
    //             $nestedData = array();
    //             $encryptedId = EncryptDecrypt::encrypt($key->id);
    //             $nestedData[] = $i+1;
    //             $nestedData[] = ($key->title ? $key->title : 'NA');
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
    //             $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
    //             $nestedData[] = '<a href="javascript:void(0);" onclick="editExclusive(\''.$encryptedId.'\')"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteExclusive(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
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

    public function list(){
        $exclusives=Exclusive::all();
        if($exclusives){
            return response()->json(['success'=>true,'msg' => 'Exclusive found.', 'data' => $exclusives],200);
        }
        return response()->json(['error'=>true,'msg' => 'Exclusive not found.'],404);
    }
    

    public function get(Request $request) {
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateExclusive::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        //$id = EncryptDecrypt::decrypt($id);
        $exclusive = Exclusive::select('title', 'status', 'created_at', 'updated_at')->where('id', $id)->first();
        if($exclusive)
            return response()->json(['success'=>true, 'msg' => 'Exclusive found.', 'data' => $exclusive], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching exclusive.' ],500);
    }

    public function save(Request $request){
        $input = $request->all();
        $validation = ValidateExclusive::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $checkExclusive = Exclusive::where('title', $input['title'])->first();
        if(!$checkExclusive){
            $exclusiveCreated = Exclusive::create($input);
            if($exclusiveCreated)
                return response()->json(['success'=>true, 'msg' => 'Exclusive is successfully saved.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error creating exclusive.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Exclusive name already exists' ],403);
    }

    public function updateOne(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        if($id){
           // $mainid = EncryptDecrypt::decrypt($id);
            $mainid = $id;
            $validation = ValidateExclusive::update($input);
            if($validation->fails())  
                return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
            $exclusiveCheck = Exclusive::where('id', $mainid)->first();
            if($exclusiveCheck){
                $checkExist = Exclusive::where('title', $input['title'])->where('id', "!=", $mainid)->first();
                if(!$checkExist){
                    unset($input["id"]);
                    $exclusiveUpdated = Exclusive::where('id', $mainid)->update($input);
                    if($exclusiveUpdated){
                        return response()->json(['success'=>true, 'msg' => 'Exclusive is successfully updated.'], $this->successStatus);
                    }else return response()->json(['success'=>false, 'msg' => 'Error creating exclusive.' ],500);
                }else return response()->json(['success'=>false, 'msg' => 'Exclusive name already exists' ],403);
            }else return response()->json(['success'=>false, 'msg' => 'Exclusive not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function deleteOne(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateExclusive::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        //$id = EncryptDecrypt::decrypt($id);
        $exclusiveCheck = Exclusive::where('id', $id)->first();
        if($exclusiveCheck){
            $deleted = $exclusiveCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Exclusive is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting Exclusive.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting Exclusive.' ],404);
    }
}
