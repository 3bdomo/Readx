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
use Symfony\Component\Console\Input\Input;

class ProjectController extends Controller
{
    //
    public function show(): \Illuminate\Http\JsonResponse
    {

        $project = Project::latest()->paginate(5);
        return $this->pagination($project);

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

        // Retrieve the search query from the request
        $query = $request->input('query');

        // Retrieve the filter value from the request
        $filter = $request->input('filter');

        // Perform the search based on the query and filter
        $projects = Project::query();

        // If a filter is specified, order the results by the specified column
        if ($filter) {
            // Check if the filter value is a valid column name
            if (in_array($filter, ['name', 'description', 'field', 'output', 'faculty', 'year', 'technologies', 'assistant_teacher_name', 'assistant_teacher_email', 'professor_name', 'professor_email'])) {
                // If it's valid, use it as a column name in the query
              $projects->where($filter, 'like', '%' . $query . '%');
            }
        }

        // If no filter is specified, search in all columns
        if (!$filter) {
          $projects->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('field', 'like', '%' . $query . '%')
                    ->orWhere('output', 'like', '%' . $query . '%')
                    ->orWhere('faculty', 'like', '%' . $query . '%')
                    ->orWhere('year', 'like', '%' . $query . '%')
                    ->orWhere('technologies', 'like', '%' . $query . '%')
                    ->orWhere('assistant_teacher_name', 'like', '%' . $query . '%')
                    ->orWhere('assistant_teacher_email', 'like', '%' . $query . '%')
                    ->orWhere('professor_name', 'like', '%' . $query . '%')
                    ->orWhere('professor_email', 'like', '%' . $query . '%');

        }

        // Get the results
        $project = $projects->paginate(5)?? 0;
       $project->appends(['query' =>$query,'filter' =>$filter]);

        return $this->pagination($project);
    }


    public function pagination($project): \Illuminate\Http\JsonResponse
    {
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
        return ApiResponse::sendResponse(200, 'no projects founded', []);
    }
}
