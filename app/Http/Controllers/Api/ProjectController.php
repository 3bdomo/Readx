<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Api\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class ProjectController extends Controller
{
    use  paginationTrait;
    use SearchTrait;
    public function show_GP(): \Illuminate\Http\JsonResponse
    {

        $project = Project::latest()->paginate(5);
        return $this->pagination($project,ProjectResource::class);

    }


    public function submit_GP(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255'],
            'description' => ['required','string','min:100'],
            'output' => ['required','string'],
            'field' => ['required','string'],
        ]);
        $user=auth::user();
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }


        if($user->project_id!=null){
            return ApiResponse::SendResponse(200,"there is a registered project for this user ",'');

        }


       $project=Project::create([
           'name' =>$request->name,
           'description' => $request->description,
           'output' => $request->output,
           'field' => $request->field,
           'status' =>'pending',
           'year' =>date('Y'),

       ]);


        $user->project_id =$project->id;
        $user->save();
        return ApiResponse::SendResponse(201, "Uploaded successfully", "");


    }


    //get the registered project if exist
    public function get_GP(): \Illuminate\Http\JsonResponse
    {

        $project=auth()->user()->project;


        if($project!=null){
           // $project->append(['flag'=>true]);
            return ApiResponse::SendResponse(200,'',new ProjectResource($project));
        }
       else {
           return ApiResponse::SendResponse(200, 'No project founded','' );
       }
    }


    public function search_GP(Request $request): \Illuminate\Http\JsonResponse
    {
        $columns_name=['name','description', 'field','status','output','year' ,
            'used_technologies','Prof_name','Assistant_teacher_name','classification', 'faculty' ];

        // Get the results
        $projects = $this->search(Project::class, $request,$columns_name) ?? 0;

        return $this->pagination($projects,ProjectResource::class);
    }



}
