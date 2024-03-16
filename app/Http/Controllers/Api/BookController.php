<?php

namespace App\Http\Controllers\Api;

use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Resources\BookResource;
use App\Models\Api\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    use  paginationTrait;
    use SearchTrait;
    public function get_book(){
        $books=Book::paginat(5);
        return $this->pagination($books,BookResource::class);
    }
public function search_book(Request $request){

    // Get the results
    $projects = $this->search(Book::class, $request) ?? 0;

    return $this->pagination($projects,BookResource::class);
    }

}
