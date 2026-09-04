<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;

    // Shared PK pattern: librarians.id IS users.id (class-table inheritance)
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function reviewedStudents()
    {
        return $this->hasMany(Student::class, 'reviewed_by_librarian_id');
    }

    public function verifiedSelfReturnReports()
    {
        return $this->hasMany(SelfReturnReport::class, 'verified_by_librarian_id');
    }

    public function reviewedBookSuggestions()
    {
        return $this->hasMany(BookSuggestion::class, 'reviewed_by_librarian_id');
    }

    public function staffedResourceUsageLogs()
    {
        return $this->hasMany(ResourceUsageLog::class, 'staff_librarian_id');
    }
}
