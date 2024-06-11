<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\ResearchResource;
use App\Models\Api\Book;
use App\Models\Api\Research;
use Illuminate\Http\Request;

class ResearchController extends Controller
{

    use  paginationTrait;
    use SearchTrait;
    public function get_research(){
        $researches=Research::get();
        return ApiResponse::SendResponse(200,'',$researches);
    }
    public function search_research(Request $request){

        $columns_name=[ 'name','researcher_name','researcher_email','publishing_year',
            'field','description','the_supervisory_authority','status','faculty'];
        // Get the results
        $researches = $this->search(Research::class, $request,$columns_name) ?? 0;

        return $this->pagination($researches,ResearchResource::class);
    }
}
