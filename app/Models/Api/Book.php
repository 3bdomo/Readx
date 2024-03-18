<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'author_name',
        'publisher',
        'publishing_year',
        'edition',
        'category',
        'ISBN',
        'description',
        'rating',
        'status',
        'faculty'
    ];
}
