<?php

namespace App\Helpers;

use App\Http\Resources\ProjectResource;

trait paginationTrait
{

    public function pagination($project,$resource): \Illuminate\Http\JsonResponse
    {
        if (count($project) > 0) {
            if ($project->total() > $project->perPage()) {
                $data = [
                    'records' => $resource::collection($project),
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
                $data = $resource::collection($project);
            }
            return ApiResponse::sendResponse(200, '', $data);
        }
        return ApiResponse::sendResponse(200, 'no projects founded', []);
    }

}
