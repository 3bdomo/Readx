<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResearchResource;
use App\Models\Api\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminResearchController extends Controller
{
    //upload,edit,show,search, delete
    use paginationTrait;
    use SearchTrait;
    public function upload_research(Request $request)
    {
        //upload a research
        $validator=Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'researcher_name'=>['required','string',],
            'field'=>['required','string'],
            'researcher_email'=>['sometimes','email'],
            'faculty'=>['required','string'],
            'the_supervisory_authority'=>['required','string'],
            'description'=>['required','string'],
            'publishing_year'=>['required','string'],
            'status'=>['required','string'],
            'file'=>['sometimes','file'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }

$research=Research::create([
            'name'=>$request->name,
            'researcher_name'=>$request->researcher_name,
            'field'=>$request->field,
            'researcher_email'=>$request->researcher_email,
            'faculty'=>$request->faculty,
            'the_supervisory_authority'=>$request->the_supervisory_authority,
            'description'=>$request->description,
            'publishing_year'=>$request->publishing_year,
            'status'=>$request->status,
        ]);

        if($request->hasFile('file')){
            $file=$request->file('file');
            $file_name=$file->getClientOriginalName();
            $file->move('storage/files/researches',$file_name);
            $research->file=$file_name;
            $research->save();
        }
        return ApiResponse::SendResponse(201,"Research uploaded successfully",$research);
    }


    public function update_research(Request $request, $research_id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name'        => ['sometimes', 'string', 'max:255'],
            'researcher_name' => ['sometimes', 'string'],
            'field'       => ['sometimes', 'string'],
            'researcher_email' => ['sometimes', 'email'],
            'faculty'     => ['sometimes', 'string'],
            'the_supervisory_authority' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'publishing_year' => ['sometimes', 'string'],
            'status'      => ['sometimes', 'string'],
            'file'        => ['sometimes', 'file'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }
        $research=Research::find($research_id);
        if(!$research){
            return ApiResponse::SendResponse(404,"Research not found",'');
        }
        $research->update($request->all());
        if($request->hasFile('file')){
            $file=$request->file('file');
            $file_name=$file->getClientOriginalName();
            $file->move('storage/files/researches',$file_name);
            $research->file=$file_name;
            $research->save();
        }
        return ApiResponse::SendResponse(200,"Research updated successfully",$research);
    }

    public function delete_research($research_id)
    {
        $research = Research::find($research_id);
        if (!$research) {
            return ApiResponse::SendResponse(404, "Research not found", '');
        }
        $research->delete();
        return ApiResponse::SendResponse(200, "Research deleted successfully", '');
    }

    public function show_research($research_id)
    {
        $research = Research::find($research_id);
        if (!$research) {
            return ApiResponse::SendResponse(404, "Research not found", '');
        }
        return ApiResponse::SendResponse(200, "Research found successfully", $research);
    }

    public function search_research(Request $request)
    {
        $columns = ['name', 'researcher_name', 'field', 'researcher_email', 'faculty', 'the_supervisory_authority', 'description', 'publishing_year', 'status'];
        $researches = $this->search(Research::class, $request, $columns);
        return $this->pagination($researches,ResearchResource::class);
    }
    public function show_all_researches(Request $request)
    {
        $researches = $this->pagination(Research::class, $request);
        return $this->pagination($researches,ResearchResource::class);
    }

}
