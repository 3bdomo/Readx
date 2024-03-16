<?php

namespace App\Helpers;

use App\Models\Api\Project;

trait SearchTrait
{
    public function search($model, $request)
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
            if (in_array($filter, ['name', 'description', 'field', 'output', 'faculty', 'year', 'technologies', 'assistant_teacher_name', 'assistant_teacher_email', 'professor_name', 'professor_email'])) {
                // If it's valid, use it as a column name in the query
                $q->where($filter, 'like', '%' . $query . '%');
            }
        }

        // If no filter is specified, search in all columns
        if (!$filter) {
            $q->where('name', 'like', '%' . $query . '%')
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
        $res= $q->paginate(5);
        $res->appends(['query' =>$query,'filter' =>$filter]);;

        return $res;

    }
}
