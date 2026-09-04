<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'res_id', 'student_id', 'staff_librarian_id', 'start_time', 'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'res_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function staffLibrarian()
    {
        return $this->belongsTo(Librarian::class, 'staff_librarian_id');
    }
}
