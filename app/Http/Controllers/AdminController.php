<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;


class AdminController extends Controller
{
    //
    public function loginForm(){
        return view('admin/loginForm');
    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),
        [
            'username'=>'required|string',
            'password'=>'required|string',
        ]);
        if($validator->fails()) {
            return back()->withErrors(['username' => 'Invalid credentials']);
        }
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();
            Auth::guard('admin')->user()->tokens()->delete();//delete odl tokens
            $token =  $admin->createToken('MyAuthApp')->plainTextToken;
            $accessToken = new PersonalAccessToken();
            $accessToken->tokenable_id = $admin->id;
            $accessToken->tokenable_type = Admin::class;
            $accessToken->name = 'Token Name';
            $accessToken->token = hash('sha256', $token); // Hash the token before saving (optional)
            $accessToken->save();
            return view('admin/logoutForm');
        } else {
            return back()->withErrors(['username' => 'Invalid credentials']);
        }
    }


    public function logout(Request $request)
    {
        // Check if admin is authenticated
        if (Auth::guard('admin')->check()) {
            // Revoke all tokens...
            Auth::guard('admin')->user()->tokens()->delete();

        }

        return view('admin/loginForm');
    }


}
