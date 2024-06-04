<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];
    protected  $table = 'settings';
}
