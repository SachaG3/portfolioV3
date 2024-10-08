<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'nom', 'icone'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

