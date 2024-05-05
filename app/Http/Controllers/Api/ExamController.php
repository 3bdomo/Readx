<?php

namespace App\Http\Controllers\Api;
use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Api\Exam;
use Illuminate\Http\Request;


class ExamController extends Controller
{
    use paginationTrait;
public function show_exams(Request $request)# where
{
    $books=Exam::paginate(5);
    return $this->pagination($books,ExamResource::class);

 }


    public function search_exam(Request $request): \Illuminate\Http\JsonResponse
    {
        $columns = [ 'subject_name', 'year', 'type', 'professor_name', 'grade'];
        $exams = $this->search(Exam::class, $request,$columns);
        return ApiResponse::SendResponse(200, "Exams found", ExamResource::collection($exams));
    }
}
