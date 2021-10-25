<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as Authenticate;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Cookie;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/v1';
    public $successStatus = 200;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
           'email' => 'required|string|email|max:255',
           'password' => 'required|string|min:6',
           'role' => 'required|string',
        ]);
        if ($validator->fails()) 
           return response(['errors'=>$validator->errors()->all()], 422);
        $credentials = request(['email', 'password']);
        $user = User::where(['email' => $request->email, 'role' => $request->role])->first();
        if($user) {
            if($user->role == 'vendor' && $user->is_verify == 0){
                return response()->json([ 'success'=>false, 'msg' => 'Profile is not verified, please contact to administrator.' ], 401);
            }
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            if(!Auth::attempt($credentials)){
                $this->incrementLoginAttempts($request);
                return response()->json([ 'success'=>false, 'msg' => 'Invalid Credentials!' ], 401);
            }
            $this->clearLoginAttempts($request);
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addHours(24);
            $token->save();
            $cookie = cookie('adventure_karo', $tokenResult->accessToken, time()+86400,null,null,env('SESSION_SECURE_COOKIE'),env('HTTP_ONLY'));
            return response()->json([ 'success'=>true, 'msg' => 'Login successfully', 'data'=> ['access_token' => $tokenResult->accessToken, 'token_type' => 'Bearer', 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(), 'name' => \Auth::user()->name, ] ],$this->successStatus)->cookie($cookie);
        } else return response()->json([ 'success'=>false, 'msg' => 'User does not exist'],422);
   }

    public function logout(Request $request){
        $cookie = Cookie::forget('adventure_karo');
        $session = Session::forget('role');
        return response()->json([ 'success'=>true, 'msg' => 'Successfully logged out' ],$this->successStatus)->cookie($cookie);
    }
}
