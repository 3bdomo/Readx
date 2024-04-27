<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchResource extends JsonResource
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
            'researcher_name'=>$this->researcher_name,
            'researcher_email'=>$this->researcher_email,
            'publishing_year'=>$this->publishing_year,
            'category'=>$this->category,
            'field'=>$this->field,
            'description'=>$this->description,
            'the supervisory authority'=>$this->the_supervisory_authority,
            'status'=>$this->status,
            'faculty'=>$this->faculty,
            'file'=>$this->file,
            ];
    }
}
