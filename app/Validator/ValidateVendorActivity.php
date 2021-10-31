<?php 

namespace App\Validator;
use Illuminate\Http\Request;
use Exception;

class ValidateVendorActivity
{
    public static function store($input){
        $rules = [
            'activity_id' => 'required|string',
            'inclusives' => 'required|string',
            'exclusives' => 'required|string',
            'info' => 'required|string',
            'days' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'image'  => 'required|array',
        ];
        $messages = [];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function update($input){
        $rules = [
            'activity_id' => 'required|string',
            'inclusives' => 'required|string',
            'exclusives' => 'required|string',
            'info' => 'required|string',
            'days' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'image'  => 'array',
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

}