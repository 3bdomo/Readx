<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Helpers\ImageUploadTrait;
use App\Helpers\paginationTrait;
use App\Helpers\SearchTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Api\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBookController extends Controller
{
    //upload,edit,show,search, delete
    use paginationTrait;
    use SearchTrait;
    use ImageUploadTrait;
    public function upload_book(Request $request)
    {
        //upload a book
        $validator=Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'author_name'=>['required','string','max:255'],
            'description'=>['required','string',],
            'category'=>['required','string'],
            'image'=>['sometimes','image'],
            'publishing_year'=>['required','string'],
            'publisher'=>['required','string'],
            'edition'=>['required','string'],
            'ISBN'=>['required','string','unique:books'],
            'rating'=>['sometimes','numeric'],
            'status'=>['required','string'],
            'faculty'=>['required','string'],
            'pages_number'=>['required','integer'],
        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }

        $book=Book::create([
            'name'=>$request->name,
            'author_name'=>$request->author_name,
            'description'=>$request->description,
            'category'=>$request->category,
            'publishing_year'=>$request->publishing_year,
            'publisher'=>$request->publisher,
            'edition'=>$request->edition,
            'ISBN'=>$request->ISBN,
            'rating'=>$request->rating,
            'status'=>$request->status,
            'faculty'=>$request->faculty,
            'pages_number'=>$request->pages_number,
        ]);
        $image_name= $this->handleImageUpload($request, 'storage/images/BooksCovers/');
        $book->image=$image_name;
        $book->save();
        return ApiResponse::SendResponse(201,"Book uploaded successfully",new BookResource($book));


    }
    public function update_book($id,Request $request)
    {
        //edit a book
        $book=Book::find($id);
      //  dd($book);
        if(!$book){
            return ApiResponse::SendResponse(404,"Book not found",'');
        }
        $validator=Validator::make($request->all(),[
            'name'=>['sometimes','string','max:255'],
            'author_name'=>['sometimes','string','max:255'],
            'description'=>['sometimes','string'],
            'category'=>['sometimes','string'],
            'image'=>['sometimes','image'],
            'publishing_year'=>['sometimes','string'],
            'publisher'=>['sometimes','string'],
            'edition'=>['sometimes','string'],
            'ISBN'=>['sometimes','string','unique:books'],
            'rating'=>['sometimes','numeric'],
            'status'=>['sometimes','string'],
            'faculty'=>['sometimes','string'],
            'pages_number'=>['sometimes','integer'],

        ]);
        if($validator->fails()){
            return ApiResponse::SendResponse(422,"Validation failed",$validator->errors());
        }



       $book->update([
           'name'=>$request->name??$book->name,
            'author_name'=>$request->author_name??$book->author_name,
            'description'=>$request->description??$book->description,
            'category'=>$request->category??$book->category,
            'publishing_year'=>$request->publishing_year??$book->publishing_year,
            'publisher'=>$request->publisher??$book->publisher,
            'edition'=>$request->edition??$book->edition,
            'ISBN'=>$request->ISBN??$book->ISBN,
            'rating'=>$request->rating??$book->rating,
            'status'=>$request->status??$book->status,
            'faculty'=>$request->faculty??$book->faculty,
            'pages_number'=>$request->pages_number??$book->pages_number,

        ]
       );
       // if($request->has('image')){
        $image_name= $this->handleImageUpload($request, 'storage/images/BooksCovers/');
        $book->image=$image_name;
        $book->save();
            dd($image_name);
            $book->save();
       // }
        return ApiResponse::SendResponse(200,"Book updated successfully",new BookResource($book));

    }
    public function delete_book($id)
    {
        //delete a book
        $book=Book::find($id);
        if(!$book){
            return ApiResponse::SendResponse(404,"Book not found",'');
        }
        $book->delete();
        return ApiResponse::SendResponse(200,"Book deleted successfully",'');
    }

    public function show_book($id)
    {
        //show a book
        $book=Book::find($id);
        if(!$book){
            return ApiResponse::SendResponse(404,"Book not found",'');
        }
        return ApiResponse::SendResponse(200,"Book found", new BookResource($book));
    }
    public function search_book(Request $request)
    {
        //search for a book
        $columns_name=['name','faculty', 'status','rating','ISBN','category' ,'description',
            'publishing_year','publisher','author_name','edition','pages_number' ];

        // Get the results
        $projects = $this->search(Book::class, $request,$columns_name) ?? 0;

        return $this->pagination($projects,BookResource::class);
    }

    public function get_all_books()
    {
        //get all books
        $books = Book::latest()->paginate(10);
        return $this->pagination($books,BookResource::class);
    }

}
