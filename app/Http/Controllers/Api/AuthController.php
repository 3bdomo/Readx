<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator =Validator::make($request->all(),
        [
            'first_name'=>['required','max:255','string'],
            'last_name'=>['required','max:255','string'],
            'email'=>['required','email','unique:'. User::class] ,
            'password'=>['required','min:6'],
            'student_id'=>['required','unique:'.User::class,'integer'],

        ],[],[
            'first_name'=>'First Name',
            'last_name'=>'Last Name',
            'email'=>'Email',
            'student_id'=>'Student ID',
            'password'=>'Password',
        ]);

        if($validator->fails() ){
            return ApiResponse::SendResponse(422,'error',$validator->messages()->all());

        }
      $user=User::create([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'password'=>$request->password,
        'email'=>$request->email,
        'student_id'=>$request->student_id,
    
      ]);
      $data['token']= $user->createToken('user_token')->plainTextToken;
      $data['name']=$request->first_name;
      return ApiResponse::SendResponse(201,"Registration successfully",$data);





  


    }
    public function login(){
        
    }
    public function logout(){
        
    }
}
