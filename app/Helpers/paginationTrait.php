<?php

namespace App\Helpers;



trait paginationTrait
{

    public function pagination($items,$resource): \Illuminate\Http\JsonResponse
    {
        if (count($items) > 0) {
            if ($items->total() > $items->perPage()) {
                $data = [
                    'records' => $resource::collection($items),
                    'pagination links' => [
                        'current page' => $items->currentPage(),
                        'per page' => $items->perPage(),
                        'total' => $items->total(),
                        'links' => [
                            'first' => $items->url(1),
                            'next' => $items->nextPageUrl(),
                            'previous' => $items->previousPageUrl(),
                            'last' => $items->url($items->lastPage()),
                        ],
                    ],
                ];
            } else {
                $data = $resource::collection($items);
            }
            return ApiResponse::sendResponse(200, '', $data);
        }
        return ApiResponse::sendResponse(200, 'no items founded', []);
    }

}
