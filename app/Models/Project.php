<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'lien'];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function technologies()
    {
        return $this->hasMany(Technology::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
