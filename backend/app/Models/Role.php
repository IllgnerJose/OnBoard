<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\UserRole;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];
}
