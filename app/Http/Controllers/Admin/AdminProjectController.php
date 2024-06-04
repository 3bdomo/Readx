<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Api\Project;
use App\Models\Api\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use \Illuminate\Support\Facades\Validator;



class AdminProjectController extends Controller
{
    use  paginationTrait;
    use SearchTrait;

///update ,delete , accept ,reject;


    public function upload_project(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255'],
            'description' => ['required','string','min:100'],
            'output' => ['required','string'],
            'field' => ['required','string'],
            'student_id'=>['required','integer'],
            'technologies'=>['required','string'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }
        $student_id=$request->student_id;
        $user=User::where('student_id',$student_id)->first();
        if(!$user){
            return ApiResponse::SendResponse(422,"Student ID {$student_id} not found",'');
        }
        $project=Project::create([
            'name' =>$request->name,
            'description' => $request->description,
            'output' => $request->output,
            'field' => $request->field,
            'status' =>'pending',
            'year' =>date('Y'),
            'technologies' => $request->technologies,

        ]);
        $user->project_id =$project->id;
        $user->save();
        return ApiResponse::SendResponse(201, "Uploaded successfully", '');

    }
    public function update_project(Request $request, $project_id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name'        => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'min:100'],
            'output'      => ['sometimes', 'string'],
            'field'       => ['sometimes', 'string'],
            'technologies'=> ['sometimes', 'string'],
            'status'      => ['sometimes', 'string', 'in:pending,accepted,rejected'], // Example of possible statuses
        ]);

        if ($validator->fails()) {
            return ApiResponse::SendResponse(422, "Validation failed", $validator->errors());
        }

        // Find the existing project by ID
        $project = Project::find($project_id);
        if (!$project) {
            return ApiResponse::SendResponse(404, "Project not found", '');
        }

        // Update project details
        $project->update([
            'name'        => $request->name ?? $project->name,
            'description' => $request->description ?? $project->description,
            'output'      => $request->output ?? $project->output,
            'field'       => $request->field ?? $project->field,
            'technologies'=> $request->technologies ?? $project->technologies,
            'status'      => $request->status ?? $project->status,
        ]);

        // Optionally, update the year if that's required
        // $project->year = date('Y');
        // $project->save();

        return ApiResponse::SendResponse(200, "Project updated successfully", '');
    }

    public function delete_project($project_id)
    {
        // Find the existing project by ID
        $project = Project::find($project_id);
        if (!$project) {
            return ApiResponse::SendResponse(404, "Project not found", '');
        }

        // Delete the project
        $project->delete();

        return ApiResponse::SendResponse(200, "Project deleted successfully", '');
    }
   public function accept_project($project_id)
    {
        // Find the existing project by ID
        $project = Project::find($project_id);
        if (!$project) {
            return ApiResponse::SendResponse(404, "Project not found", '');
        }

        // Update the project status to accepted
        $project->update([
            'status' => 'accepted',
        ]);

        return ApiResponse::SendResponse(200, "Project accepted successfully", '');
    }
    public function reject_project($project_id)
    {
        // Find the existing project by ID
        $project = Project::find($project_id);
        if (!$project) {
            return ApiResponse::SendResponse(404, "Project not found", '');
        }

        // Update the project status to rejected
        $project->update([
            'status' => 'rejected',
        ]);

        return ApiResponse::SendResponse(200, "Project rejected successfully", '');
    }


    public function get_project($project_id)
    {
        // Find the existing project by ID
        $project = Project::with('users')->find($project_id);
        if (!$project) {
            return ApiResponse::SendResponse(404, "Project not found", '');
        }

        return ApiResponse::SendResponse(200, "Project details", new ProjectResource($project));
    }
    public function get_accepted_projects()
    {
        $project = Project::with('users')->where('status','accepted')->latest()->paginate(10);
        return $this->pagination($project,ProjectResource::class);
    }
    public function get_rejected_projects()
    {
        $project = Project::with('users')->where('status','rejected')->latest()->paginate(10);
        return $this->pagination($project,ProjectResource::class);
    }
    public function get_pending_projects()
    {
        $project = Project::with('users')->where('status','pending')->latest()->paginate(10);
      //  return ApiResponse::SendResponse(200,'',$project) ;
        return $this->pagination($project,ProjectResource::class);
    }

    public function get_all_projects()
    {
        $project = Project::with('users')->latest()->paginate(10);
        return $this->pagination($project,ProjectResource::class);
    }

    public function get_current_year_projects(){
        $project = Project::with('users')->where('year',date('Y'))->latest()->paginate(10);
        return $this->pagination($project,ProjectResource::class);
    }
    public function get_previous_projects(){
        $project = Project::with('users')->where('year','!=',date('Y'))->latest()->paginate(10);
        return $this->pagination($project,ProjectResource::class);
    }
    public function get_registration_status()
    {
        try{
           $registration_status = Setting::where('key','registration_status')->first();
            return ApiResponse::SendResponse(200, "Registration status", $registration_status->value);

        }catch (\Exception $e){
            return ApiResponse::SendResponse(500, "Error occurred", $e->getMessage());
        }
    }
    public function open_registration()
    {
        try {
          Setting::where('key','registration_status')->update(['value'=>'opened']);
            return ApiResponse::SendResponse(200, "Registration opened successfully", );

        } catch (\Exception $e) {
            return ApiResponse::SendResponse(500, "Error occurred", $e->getMessage());
        }

    }
    public function close_registration()
    {
        try {
            Setting::where('key','registration_status')->update(['value'=>'closed']);
            return ApiResponse::SendResponse(200, "Registration closed successfully",);

        } catch (\Exception $e) {
            return ApiResponse::SendResponse(500, "Error occurred", $e->getMessage());
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

}
