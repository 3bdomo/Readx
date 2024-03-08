<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Dflydev\DotAccessData\Data;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    //
    public function show(): \Illuminate\Http\JsonResponse
    {

        $project = Project::latest()->paginate(5);
        if (count($project) > 0) {
            if ($project->total() > $project->perPage()) {
                $data = [
                    'records' => projectResource::collection($project),
                    'pagination links' => [
                        'current page' => $project->currentPage(),
                        'per page' => $project->perPage(),
                        'total' => $project->total(),
                        'links' => [
                            'first' => $project->url(1),
                            'next' => $project->nextPageUrl(),
                            'previous' => $project->previousPageUrl(),
                            'last' => $project->url($project->lastPage()),
                        ],
                    ],
                ];
            } else {
                $data = ProjectResource::collection($project);
            }
            return ApiResponse::sendResponse(200, '', $data);
        }
        return ApiResponse::sendResponse(200, 'no projects found', []);

    }


    public function submit(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255'],
            'description' => ['required','string'],
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


    public function get_GP(): \Illuminate\Http\JsonResponse
    {

        $project=auth()->user()->project;
        if($project!=null){
            return ApiResponse::SendResponse(200,'',new ProjectResource($project));
        }
       else {
           return ApiResponse::SendResponse(200, 'No project founded','' );
       }
    }
}
