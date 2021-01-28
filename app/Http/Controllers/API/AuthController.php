<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator ;

class AuthController extends Controller
{
    public function register()
    {
        $validator = Validator::make(Request::all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response([
                'error'=>$validator->errors()
            ]);
        }
        $input = Request::all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token =  $user->createToken('app')->accessToken;
        return response([
            'msg'=>'success',
            'token'=>$token,
            'user'=>$user,
        ]);
    }
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' =>request('password')])) {
            $user = Auth::user();
            $token=  $user->createToken('app')->accessToken;
            
            return response([
                'msg'=>'successfully login',
                'token'=>$token,
                'user'=>$user,
            ], 200);
        }
        return response([
                'msg'=>'Invalid credentials.'
            ], 400);
    }
    public function forgetPassword()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email',
           
        ]);
        if ($validator->fails()) {
            return response([
                'error'=>$validator->errors()
            ]);
        }
        if (!User::where('email', request('email'))->first()) {
            return response([
                'error'=>'Email does not exist'
            ], 400);
        }
        $token=rand(10, 100000);
        DB::table('password_resets')->insert([
            'email'=>request('email'),
            'token'=>$token,
            'created_at'=>now(),
        ]);
        Mail::to(request('email'))->send(new ForgetPasswordMail($token));
        return response([
    'msg'=>'Forget password mail sent.'
], 200);
    }
    public function resetPassword()
    {
        $validator = Validator::make(Request::all(), [
            'token' => 'required',
            // 'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response([
                'error'=>$validator->errors()
            ],400);
        }
        $token=request('token');
        $password=bcrypt(request('password'));
        $user=DB::table('password_resets')->where('token',$token)->first();
       
        if (!$user) {
            return response([
                'msg'=>'Invalid token.'
            ],400);
        }
        User::where('email',$user->email)->update(['password'=>$password]);
        DB::table('password_resets')->where('email',$user->email)->delete();
        return response([
            'msg'=>'Password changed.'
        ],200);
    }
}
