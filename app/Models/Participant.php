<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'nom', 'avatar'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
