<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'book_id', 'loan_type',
        'checkout_date', 'due_date', 'return_date', 'status',
    ];

    protected $casts = [
        'checkout_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function selfReturnReport()
    {
        return $this->hasOne(SelfReturnReport::class, 'loan_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'loan_id');
    }

    public function isOverdue(): bool
    {
        return $this->status === 'Active' && $this->due_date->isPast();
    }
}
