<?php

namespace App\Helpers;

use App\Models\Api\Project;

trait SearchTrait
{
    public function search($model, $request, $columns_name)
    {
        // Retrieve the search query from the request
        $query = $request->input('query');

        // Retrieve the filter value from the request
        $filter = $request->input('filter');

        // Perform the search based on the query and filter
        $q = $model::query();

        // If a filter is specified, order the results by the specified column
        if ($filter) {
            // Check if the filter value is a valid column name
            if (in_array($filter, $columns_name)) {
                // If it's valid, use it as a column name in the query
                $q->where($filter, 'like', '%' . $query . '%');
            }
        }

        // If no filter is specified, search in all columns
        if (!$filter) {
            $q->whereAny($columns_name, 'like', '%' . $query . '%');

        }
        $res= $q->paginate(5);
        $res->appends(['query' =>$query,'filter' =>$filter]);;

        return $res;

    }
}
