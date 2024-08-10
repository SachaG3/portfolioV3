<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleUser extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'is_active'];
}
