<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'reviewed_by_librarian_id', 'title', 'author',
        'reason', 'status', 'progress_step', 'submitted_at',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(Librarian::class, 'reviewed_by_librarian_id');
    }
}
