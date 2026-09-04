<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'book_id', 'status', 'reserved_at'];

    protected $casts = ['reserved_at' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
