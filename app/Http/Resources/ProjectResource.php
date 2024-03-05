<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'Prof_name' => $this->professor_name,
            'Prof_email' => $this->professor_email,
            'Assistant_teacher_name' => $this->assistant_teacher_name,
            'Assistant_teacher_email' => $this->assistant_teacher_email,
            'classification' => $this->classification,
            'faculty' => $this->faculty,
        ];
    }
}
