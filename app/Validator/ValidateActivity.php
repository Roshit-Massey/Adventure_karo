<?php 

namespace App\Validator;
use Illuminate\Http\Request;
use Exception;

class ValidateActivity
{
    public static function store($input){
        $rules = [
            'title' => 'required|string|regex:/^[a-zA-Z0-9 .-]*$/',
            'info' => 'required|string',
            'details' => 'required|string',
            'image'  => 'required|mimes:jpeg,jpg,png|max:10000',
        ];
        $messages = [];
        $validation =  \Validator::make($input, $rules, $messages);
        return $validation;
    }

    public static function update($input){
        $rules = [
            'title' => 'required|string|regex:/^[a-zA-Z0-9 .-]*$/',
            'info' => 'required|string',
            'details' => 'required|string',
            'image'  => 'mimes:jpeg,jpg,png|max:10000',
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