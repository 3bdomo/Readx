<?php

namespace App\Http\Controllers\Api;
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
    if($request->has('grade') && $request->has('subject_name') )
    {
        $grade= $request->input('grade');
        $subject_name= $request->input('subject_name');
        $exams = Exam::where('grade','=',$grade)->orWhere('subject_name','=',$subject_name)->paginate(5);

    }elseif ($request->has('grade'))
    {
        $grade= $request->input('grade');
        $exams = Exam::where('grade','=',$grade)->paginate(5);
    }
    elseif ($request->has('subject_name'))
    {
        $subject_name= $request->input('subject_name');
        $exams = Exam::where('subject_name','=',$subject_name)->paginate(5);
    }
    else{
        $exams = Exam::orderBy('grade')->paginate(5);

    }



    return $this->pagination($exams,ExamResource::class);

}
}
