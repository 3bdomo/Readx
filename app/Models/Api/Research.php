<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table='researches';
    use HasFactory;
    protected $fillable = [
        'name',
        'researcher_name',
        'researcher_email',
        'publishing_year',
        'field',
        'description',
        'faculty',
        'the_supervisory_authority',
        'status',
        'file'
    ];
}
