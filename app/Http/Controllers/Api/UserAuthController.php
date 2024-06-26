<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'first_name' => ['required', 'max:255', 'string'],
                'last_name' => ['required', 'max:255', 'string'],
                'email' => ['required', 'email', 'unique:' . User::class],
                'password' => ['required', 'min:6', 'confirmed',Rules\Password::default()],
                'student_id' => ['required', 'unique:' . User::class, 'integer'],
                'department' => 'required|in:CS,IS,BIO,general',
                'grade' => 'required|in:1,2,3,4',

            ], [], [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'student_id' => 'Student ID',
                'password' => 'Password',
            ]);

        if ($validator->fails()) {
            return ApiResponse::SendResponse(422, 'validation error', $validator->messages()->all());

        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'student_id' => $request->student_id,
            'department' => $request->department,
            'grade' => $request->grade,

        ]);
        $data['token'] = $user->createToken('user_token')->plainTextToken;
        $data['name'] = $request->first_name;
        $data['Id'] = $user->id;
        return ApiResponse::SendResponse(201, "Registration successfully", $data);

    }



    public function login(Request $request){
        $validator =Validator::make($request->all(),
            [
                'email'=>['required','email'] ,
                'password'=>['required'],
            ],[],
            [
                'email'=>'Email',
                'password'=>'Password',
            ]);

        if($validator->fails() ){
            return ApiResponse::SendResponse(422,'validation error',$validator->errors());

        }
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {


         $user->tokens()->delete();//delete odl tokens
          $data['token'] = $user->createToken('user_token')->plainTextToken;
          $data['name'] = $user->first_name;
          $data['ID'] = $user->id;

          return ApiResponse::SendResponse(200, "login successfully", $data);

      }else{
          return ApiResponse::SendResponse(401, "invalid credentials", null);
      }
    }


    public function logout(Request $request){
           // Check if user is authenticated
            if (Auth::check()) {
                // Revoke all tokens...
                Auth::user()->tokens()->delete();

                return     ApiResponse::SendResponse(200,"logout successfully",null);
            }
            else{
                return ApiResponse::SendResponse(401, "invalid credentials", null);

            }

     }
}
