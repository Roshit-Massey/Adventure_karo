<?php 

namespace App\Validator;
use Illuminate\Http\Request;
use Exception;

class ValidateExperience
{
    public static function store($input){
        $rules = [
            'title' => 'required|string|regex:/^[a-zA-Z0-9 .-]*$/',
            'info' => 'required|string',
            'details' => 'required|string',
            'image'  => 'required|mimes:jpeg,jpg,png|max:10000',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
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
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
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