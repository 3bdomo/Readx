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
            'subject_name'=>['required','string',],
            'year'=>['required','integer'],
            'image_path'=>['sometimes','image'],
            'type'=>['required','string'],
            'professor_name'=>['string'],
            'grade'=>['required','string'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }

        $exam=Exam::create([
            'name'=>$request->name,
            'subject_name'=>$request->subject_name,
            'year'=>$request->year,
            'type'=>$request->type,
            'professor_name'=>$request->professor_name,
            'grade'=>$request->grade,
        ]);
        $image_name= $this->handleImageUpload($request, 'storage/images/ExamsCovers/');
        $exam->image=$image_name;
        $exam->save();
        return ApiResponse::SendResponse(201,"Exam uploaded successfully",new ExamResource($exam));
    }
    public function update_exam(Request $request, $exam_id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name'        => ['sometimes', 'string', 'max:255'],
            'subject_name' => ['sometimes', 'string'],
            'year'        => ['sometimes', 'integer'],
            'image_path'  => ['sometimes', 'image'],
            'type'        => ['sometimes', 'string'],
            'professor_name' => ['sometimes', 'string'],
            'grade'       => ['sometimes', 'string'],
        ]);
        if ($validator->fails()) {
            return ApiResponse::SendResponse(422, "Validation failed", $validator->errors());
        }
        $exam = Exam::find($exam_id);
        if (!$exam) {
            return ApiResponse::SendResponse(404, "Exam not found", '');
        }
        $exam->update($request->all());
        return ApiResponse::SendResponse(200, "Exam updated successfully", new ExamResource($exam));
    }
    public function delete_exam($exam_id)
    {
        $exam = Exam::find($exam_id);
        if (!$exam) {
            return ApiResponse::SendResponse(404, "Exam not found", '');
        }
        $exam->delete();
        return ApiResponse::SendResponse(200, "Exam deleted successfully", '');
    }
    public function show_exam($exam_id)
    {
        $exam = Exam::find($exam_id);
        if (!$exam) {
            return ApiResponse::SendResponse(404, "Exam not found", '');
        }
        return ApiResponse::SendResponse(200, "Exam found", new ExamResource($exam));
    }
    public function search_exam(Request $request)
    {
        $colmuns = ['name', 'subject_name', 'year', 'type', 'professor_name', 'grade'];
        $exams = $this->search(Exam::class, $request,$colmuns);
        return ApiResponse::SendResponse(200, "Exams found", ExamResource::collection($exams));
    }

    public function show_all_exams(Request $request)
    {
        $exams = $this->pagination(Exam::class, $request);
        return ApiResponse::SendResponse(200, "Exams found", ExamResource::collection($exams));
    }
}
