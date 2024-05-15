<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Resources\BookResource;
use App\Models\Api\Book;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
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

    public function rate_A_book(Request $request)
    {
        $vladator=Validator::make($request->all(), [
           'id'=>['required','exists:App\Models\Api\Book,id'] ,
            'rate'=>['required','max:5','min:0','decimal:1'],
        ]);
        if($vladator->fails()){
          return  ApiResponse::SendResponse(422,'Validation error',$vladator->errors());
        }
       $book=Book::find($request->id);
        $rate=($book->rating*$book->rates_number+$request->rate)/($book->rates_number+1);

        try {
            $book->rating=$rate;
            $book->rates_number=($book->rates_number+1);
            $book->save();
          return  ApiResponse::SendResponse(200,"rate added successfully",'');

        }  catch (Exception $e){
            return ApiResponse::SendResponse(500,"Message:  .{$e->getMessage()}",'');
        }
    }

}
