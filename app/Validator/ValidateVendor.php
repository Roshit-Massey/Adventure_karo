<?php 

namespace App\Validator;
use Illuminate\Http\Request;
use Exception;

class ValidateVendor
{
    public static function store($input){
        $rules = [
            'first_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'image'  => 'required|mimes:jpeg,jpg,png|max:10000',
        ];
        $messages = [];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function update($input){
        $rules = [
            'first_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'email' => 'required|string|email',
            'phone' => 'required|string',
        ];
        $messages = [];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function company($input){
        $rules = [
            'vendor_id' => 'required',
            'company_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'legal_company_name' => 'required|string|regex:/^[a-zA-Z .-]*$/',
            'company_website' => 'required|string',
            'contact_number' => 'required|string',
            'registered_address'  => 'required|string',
            'country_id' => 'required',
            'state_id' => 'required',
            'city' =>'required|string',
            'postal_code' => 'required|string|regex:/^[0-9 .-]*$/',
            'bank_name' =>'required|string|regex:/^[a-zA-Z .-]*$/',
            'acc_no' =>'required|string',
            'acc_holder_name' => 'required|string|regex:/^[a-zA-Z0-9 .-]*$/',
            'ifsc' =>'required|string|regex:/^[a-zA-Z0-9 .-]*$/',
        ];
        $messages = [];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function show_or_delete($input){
        $rules = [ 'id' => 'required' ];
        $messages = [ 'id.required'  => 'Invalid data received' ];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function verify($input){
        $rules = [ 'id' => 'required', 'status' => 'required' ];
        $messages = [ 'id.required'  => 'Invalid data received' ];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

}