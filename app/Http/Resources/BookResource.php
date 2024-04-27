<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=>$this->image,
            'author_name'=>$this->author_name,
            'publisher'=>$this->publisher,
            'publishing_year'=>$this->publishing_year,
            'edition'=>$this->edition,
            'category'=>$this->category,
            'description'=>$this->description,
            'ISBN'=>$this->ISBN,
            'rating'=>$this->rating,
            'status'=>$this->status,
            'faculty'=>$this->faculty,


            ];
    }
}
