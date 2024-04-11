<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;


class AdminAuthController extends Controller
{
    //
//    public function loginForm(){
//
//        return view('admin/loginForm');
//    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),
        [
            'username'=>'required|string',
            'password'=>'required|string',
        ]);
        if($validator->fails()) {
            return ApiResponse::SendResponse(422,'validation error',$validator->errors());
        }
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();
            Auth::guard('admin')->user()->tokens()->delete();//delete odl tokens
            $token =  $admin->createToken('MyAuthApp')->plainTextToken;
//            $accessToken = new PersonalAccessToken();
//            $accessToken->tokenable_id = $admin->id;
//            $accessToken->tokenable_type = Admin::class;
//            $accessToken->name = 'Token Name';
//            $accessToken->token = hash('sha256', $token); // Hash the token before saving (optional)
//            $accessToken->save();
// return view('admin/logoutForm');
            return ApiResponse::SendResponse(200, 'Login Successful', ['token' => $token]);
        } else {
            return ApiResponse::SendResponse(419, 'Login Failed','Invalid credentials');
        }
    }


    public function logout(Request $request)
    {
        // Check if admin is authenticated
        if (Auth::guard('admin')->check()) {
            // Revoke all tokens...
            Auth::guard('admin')->user()->tokens()->delete();
          //  Auth::guard('admin')->logout();
        return ApiResponse::SendResponse(200, 'Logout Successful', '');
        }
        else
        {
            return ApiResponse::SendResponse(419, 'Logout Failed','Invalid credentials');
        }
    }


}
