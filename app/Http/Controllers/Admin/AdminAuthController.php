<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;


class AdminAuthController extends Controller
{
    public function login(Request $request){
        $validator=Validator::make($request->all(),
        [
            'username'=>'required|string',
            'password'=>'required|string',
        ]);
        if($validator->fails()) {
            return ApiResponse::SendResponse(422,'validation error',$validator->errors());
        }
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password))  {

          $admin->tokens()->delete();//delete odl tokens
            $expiresAt = Carbon::now()->addDays(7);
            $token = $admin->createToken('MyAuthApp', ['*'], $expiresAt)->plainTextToken;

            return ApiResponse::SendResponse(200, 'Login Successful', ['token' => $token]);
        } else {
            return ApiResponse::SendResponse(419, 'Login Failed','Invalid credentials');
        }
    }


    public function logout(Request $request)
    {
        // Check if admin is authenticated
        if (Auth::check()) {
            // Revoke all tokens...
            Auth::user()->tokens()->delete();
          //  Auth::guard('admin')->logout();
        return ApiResponse::SendResponse(200, 'Logout Successful', '');
        }
        else
        {
            return ApiResponse::SendResponse(401, 'Logout Failed','Invalid credentials');
        }
    }


}
