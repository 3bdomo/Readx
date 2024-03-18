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
    public function get_books(){
        $books=Book::paginate(5);
        return $this->pagination($books,BookResource::class);
    }
public function search_books(Request $request){

    $columns_name=['name','author_name','publisher','publishing_year',
        'edition','category','ISBN','description','rating','status','faculty'];
    // Get the results
    $books = $this->search(Book::class, $request,$columns_name) ?? 0;

    return $this->pagination($books,BookResource::class);
    }

}
