<?php

namespace App\Http\Controllers\Api;
use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Api\Exam;
use Illuminate\Http\Request;
use App\Helpers\SearchTrait;

class ExamController extends Controller
{
    use paginationTrait;
    use searchTrait;
public function show_exams(Request $request)# where
{
    $exams=Exam::get();
    return ApiResponse::SendResponse(200,'exams fetched',$exams);

 }


    public function search_exam(Request $request): \Illuminate\Http\JsonResponse
    {
        $columns = [ 'subject_name', 'year', 'type', 'professor_name', 'grade'];
        $exams = $this->search(Exam::class, $request,$columns);
        return $this->pagination($exams,ExamResource::class);
    }
}
