<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ValidateVendor;
use EncryptDecrypt;
use App\User;
use App\CompanyInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request) {
        $requestData = $request; 
        $columns = array(2 => 'first_name', 3 => 'last_name', 4 => 'email', 5 => 'phone', 7 => 'created_at', 8 => 'updated_at');
        $search = $requestData['search']['value'];
        $data = array();
        if($search != ""){
            $totalData = User::where('role','vendor')->where(function ($query) use ($search) {
                $query->where('first_name','LIKE',"%{$search}%")->orWhere('last_name','LIKE',"%{$search}%")->orWhere('email','LIKE',"%{$search}%")->orWhere('phone','LIKE',"%{$search}%");
            })->count();
            $totalFiltered = $totalData;
            $magazines = User::where('role','vendor')->where(function ($query) use ($search) {
                $query->where('first_name','LIKE',"%{$search}%")->orWhere('last_name','LIKE',"%{$search}%")->orWhere('email','LIKE',"%{$search}%")->orWhere('phone','LIKE',"%{$search}%");
            })->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }else {
            $totalData = User::where('role','vendor')->count();
            $totalFiltered = $totalData;
            $magazines = User::where('role','vendor')->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->offset($requestData['start'])->limit($requestData['length'])->get();
        }
        $totalFiltered = sizeof($magazines);
        if($magazines && sizeof($magazines) > 0){
            $i = $requestData['start'];
            foreach($magazines as $key){
                $nestedData = array();
                $encryptedId = EncryptDecrypt::encrypt($key->id);
                $nestedData[] = $i+1;
                $nestedData[] = ($key->profile_image ? '<img src="/images/vendor/profile/'.$key->profile_image.'" alt="'.$key->first_name.'" style="width: 100px;"></img>' : 'NA');
                $nestedData[] = ($key->first_name ? $key->first_name : 'NA');
                $nestedData[] = ($key->last_name ? $key->last_name : 'NA');
                $nestedData[] = ($key->email ? $key->email : 'NA');
                $nestedData[] = ($key->phone ? $key->phone : 'NA');
                $nestedData[] = ($key->is_verify == 0 ? '<span style="color:red;">No</span>' : '<span style="color:green;">Yes</span>');
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->created_at));
                $nestedData[] = date('d-m-Y H:i:s', strtotime($key->updated_at));
                $nestedData[] = '<a href="/v1/vendor/'.$encryptedId.'"  title="Edit" style="color: #00b8ff;"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteVendor(\''.$encryptedId.'\')" title="Delete" style="color: #dc3545;"><i class="fas fa-trash-alt"></i></a>';
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
        $validation = ValidateVendor::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $vendor = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'profile_image', 'original_image_name',  'is_verify', 'created_at', 'updated_at')->with('company_information')->where('id', $id)->first();
        if($vendor)
            return response()->json(['success'=>true, 'msg' => 'Vendor found.', 'data' => $vendor], $this->successStatus);
        else return response()->json(['success'=>false, 'msg' => 'Error fetching vendor.' ],500);
    }

    public function store(Request $request){
        $input = $request->all();
        $validation = ValidateVendor::store($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/vendor/profile');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $input['profile_image'] = $name;
            $input['original_image_name'] = $image->getClientOriginalName();
        }
        $input['role'] = 'vendor';
        $input['password'] = Hash::make('test@12345');
        $vendorCreated = User::create($input);
        if($vendorCreated)
            return response()->json(['success'=>true, 'msg' => 'Vendor is successfully saved.', 'id' => EncryptDecrypt::encrypt($vendorCreated->id)], $this->successStatus);
        else
            return response()->json(['success'=>false, 'msg' => 'Error creating vendor.' ],500);
    }

    public function update(Request $request){
        $id = $request->input('id');
        if($id){
            $mainid = EncryptDecrypt::decrypt($id);
            $vendorCheck = User::where('id', $mainid)->first();
            if($vendorCheck){
                $input = $request->all();
                $validation = ValidateVendor::update($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $name = uniqid().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/profile');
                    $imagePath = $destinationPath. "/".  $name;
                    $image->move($destinationPath, $name);
                    $input['profile_image'] = $name;
                    $input['original_image_name'] = $image->getClientOriginalName();
                }
                unset($input["id"]);
                unset($input["image"]);
                $vendorUpdated = User::where('id', $mainid)->update($input);
                if($vendorUpdated){
                    $destinationPath = public_path('/images/vendor/profile');
                    if($request->hasFile('image') && file_exists($destinationPath.'/'.$vendorCheck->profile_image))
                        File::delete($destinationPath.'/'.$vendorCheck->profile_image);
                    return response()->json(['success'=>true, 'msg' => 'Vendor is successfully updated.'], $this->successStatus);
                } else return response()->json(['success'=>false, 'msg' => 'Error creating vendor.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Vendor not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }
    
    public function delete(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateVendor::show_or_delete($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $vendorCheck = User::where('id', $id)->first();
        if($vendorCheck){
            $deleted = $vendorCheck->destroy($id);
            if($deleted)
                return response()->json(['success'=>true, 'msg' => 'Vendor is successfully deleted.'], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error deleting vendor.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error deleting vendor.' ],404);
    }

    public function verify(Request $request){
        $input = $request->all();
        $id = $request->input('id');
        $validation = ValidateVendor::verify($input);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $id = EncryptDecrypt::decrypt($id);
        $vendorCheck = User::where('id', $id)->first();
        if($vendorCheck){
            $verify = User::where('id', $id)->update(['is_verify' => ($input['status'] == 0 ? 1 : 0 )]);
            if($verify)
                return response()->json(['success'=>true, 'msg' => 'Vendor is successfully '.($input['status'] == 0 ? 'verified': 'unverified')], $this->successStatus);
            else return response()->json(['success'=>false, 'msg' => 'Error verifing vendor.' ],500);
        }else return response()->json(['success'=>false, 'msg' => 'Error verifing vendor.' ],404);
    }

    public function insert(Request $request){
        $input = $request->all();
        $validation = ValidateVendor::company($input);
        $input['vendor_id'] = EncryptDecrypt::decrypt($input['vendor_id']);
        if($validation->fails())  
            return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
        $vendorCreated = CompanyInformation::create($input);
        if($vendorCreated)
            return response()->json(['success'=>true, 'msg' => 'Vendor Company Infomation is successfully saved.',], $this->successStatus);
        else
            return response()->json(['success'=>false, 'msg' => 'Error creating vendor.' ],500);
    }

    public function updateOne(Request $request){
        $id = $request->input('id');
        if($id){
            $vendor_id = EncryptDecrypt::decrypt($request->input('vendor_id'));
            $vendorCheck = CompanyInformation::where(['id' => $id, 'vendor_id' => $vendor_id])->first();
            if($vendorCheck){
                $input = $request->all();
                $validation = ValidateVendor::company($input);
                if($validation->fails())  
                    return response()->json([ 'error' => true, 'data' => $validation->errors() ], 403);
                unset($input["id"]);
                unset($input["vendor_id"]);
                $vendorUpdated = CompanyInformation::where('id', $id)->update($input);
                if($vendorUpdated){
                    return response()->json(['success'=>true, 'msg' => 'Vendor Company Information is successfully updated.'], $this->successStatus);
                } else return response()->json(['success'=>false, 'msg' => 'Error creating vendor.' ],500);
            }else return response()->json(['success'=>false, 'msg' => 'Vendor not found.' ],404);
        }else return response()->json(['success'=>false, 'msg' => 'Invalid data received.' ],403);
    }

}
