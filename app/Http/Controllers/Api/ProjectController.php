<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Admin\Admin;
use App\Models\Api\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\Api;


class ProjectController extends Controller
{
    use  paginationTrait;
    use SearchTrait;
    public function show_GP(): \Illuminate\Http\JsonResponse
    {

        $project = Project::get();
        return ApiResponse::SendResponse(200,'',$project);

    }


    public function submit_GP(Request $request){
        try {
            $registration_status = Setting::where('key', 'registration_status')->first()->value;
        }catch (\Exception $e){
            return ApiResponse::SendResponse(500, "Internal server error", $e->getMessage());
        }
        if($registration_status=='closed'){
            return ApiResponse::SendResponse(422," Registration is closed",'');
        }
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
            $project=Project::find($user->project_id)->first();
            if(($project->status=='pending'||$project->status=='accepted')){

                return ApiResponse::SendResponse(422,"You have already submitted a project",'');
            }
         //   return ApiResponse::SendResponse(200,"there is a registered project for this user ",'');

        }


       $project=Project::create([
           'name' =>$request->name,
           'description' => $request->description,
           'output' => $request->output,
           'field' => $request->field,
           'status' =>'pending',
           'year' =>date('Y'),

       ]);

        $user->registration_status=true;
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
            'technologies','professor_name','Assistant_teacher_name', 'faculty' ];

        // Get the results
        $projects = $this->search(Project::class, $request,$columns_name) ?? 0;

        return $this->pagination($projects,ProjectResource::class);
    }

    public function check_plagiarism(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'description' => ['required','string','min:100'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }
        ini_set('max_execution_time', 240);

        $resp = Http::timeout(240)->
        post("https://gp-api-03-2.onrender.com/similarity?idea=$request->description");

       return ApiResponse::SendResponse(200,"Plagiarism checked",$resp->body());

    }

    public function add_team_members(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'team_members' => ['required','array'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }
        $user=auth::user();
        $project=$user->project;
        if($project==null){
            return ApiResponse::SendResponse(422,"You have not submitted a project yet",'');
        }
        if($project->status!='accepted'){
            return ApiResponse::SendResponse(422,"You can't add members to your project",'');
        }
        $project->team_members=$request->team_members;
        $project->save();
        return ApiResponse::SendResponse(200,"Members added successfully",$project);
    }


}
