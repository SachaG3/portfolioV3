<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'type', 'image', 'contenu', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function technologies()
    {
        return $this->hasMany(Technology::class);
    }
}
