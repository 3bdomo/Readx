<?php

namespace App\Models\Api;

use App\Models\Api\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }


    protected $casts = [
        'team_members' => 'array',
    ];
}
