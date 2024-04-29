<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'subject_name'=> $this->subject_name,
            'image'=> $this->image,
            'year'=> $this->year,
            'type'=> $this->type,
            'professor_name'=> $this->professor_name,
            'grade'=> $this->grade
        ];


    }
}
