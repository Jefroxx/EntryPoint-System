<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'criteria_json'];

    protected $casts = ['criteria_json' => 'array'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_badge', 'badge_id', 'student_id')
            ->withPivot(['trigger_event', 'earned_at']);
    }
}
