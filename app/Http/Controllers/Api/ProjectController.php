<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function show(){

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
}
