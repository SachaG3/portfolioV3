<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'num_of_repos',
        'total_commits',
        'created_at',
        'updated_at',
    ];
}
