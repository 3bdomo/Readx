<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Helpers\ImageUploadTrait;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Api\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminExamController extends Controller
{
    //upload,edit,show,search, delete
    use paginationTrait;
    use SearchTrait;
    use ImageUploadTrait;
    public function upload_exam(Request $request)
    {
        //upload a exam
        $validator=Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'description'=>['required','string',],
            'category'=>['required','string'],
            'image'=>['sometimes','image'],
            'faculty'=>['required','string'],
            'duration'=>['required','string'],
            'status'=>['required','string'],
            'questions_number'=>['required','integer'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }

        $exam=Exam::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'category'=>$request->category,
            'faculty'=>$request->faculty,
            'duration'=>$request->duration,
            'status'=>$request->status,
            'questions_number'=>$request->questions_number,
        ]);
        $image_name= $this->handleImageUpload($request, 'storage/images/ExamsCovers/');
        $exam->image=$image_name;
        $exam->save();
        return ApiResponse::SendResponse(201,"Exam uploaded successfully",new ExamResource($exam));
    }

}
