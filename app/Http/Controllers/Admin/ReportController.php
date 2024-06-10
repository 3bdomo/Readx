<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\Project;
use App\Models\Api\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function get_projects_report(Request $request)
    {
        $data = [
            'registration_status' => Setting::where('key', 'registration_status')->first()->value,
        ];

        $registered_students=User::where('registration_status',true)->count();
        $grade_four_students=User::where('grade',4)->count();
        $data['submitted_students_percentage'] = ($grade_four_students != 0) ?
            round(($registered_students / $grade_four_students) * 100, 2) : null;
            $data['submitted_students'] ="$registered_students / $grade_four_students";

        $accepted_projects=Project::where('status','accepted')->where('year',date('Y'))->count();
        $all_projects=Project::where('year',date('Y'))->count();
        $data['accepted_projects_percentage'] = ($all_projects != 0) ?
            round(($accepted_projects / $all_projects) * 100, 2) : null;


        $totalProjects = Project::count();
        $data['projectsByField' ]= Project::
        select('field',  DB::raw('ROUND((count(*) / '.$totalProjects.') * 100 ,2)as percentage'))
        ->groupBy('field')
        ->get();


        return ApiResponse::SendResponse(200, "Reports fetched successfully", $data);

    }
}
