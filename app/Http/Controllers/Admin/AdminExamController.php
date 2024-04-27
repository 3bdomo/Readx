<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploadTrait;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminExamController extends Controller
{
    //upload,edit,show,search, delete
    use paginationTrait;
    use SearchTrait;
    use ImageUploadTrait;


}
