<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillIcon extends Model
{
    use HasFactory;

    protected $fillable = ['skill_id', 'svg', 'name'];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
