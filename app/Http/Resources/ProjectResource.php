<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{

    public function toArray(Request $reques): array
    {


        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'field'=>$this->field,
            'status'=>$this->status,
            'output' => $this->output,
            'year' => $this->year,
            'used_technologies' => $this->technologies,
            'Prof_name' => $this->professor_name,
            'Prof_email' => $this->professor_email,
            'Assistant_teacher_name' => $this->assistant_teacher_name,
            'Assistant_teacher_email' => $this->assistant_teacher_email,
            'classification' => $this->classification,
            'faculty' => $this->faculty,
        ];


    }
}
