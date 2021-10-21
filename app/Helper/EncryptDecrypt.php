<?php 

namespace App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Exception;

class EncryptDecrypt 
{
    public static function encrypt($value){
        $encrypted =  Crypt::encrypt($value);
        return $encrypted;
    }

    public static function decrypt($value){
        $decrypted = Crypt::decrypt($value);
        return $decrypted;
    }
}