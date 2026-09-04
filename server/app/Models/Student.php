<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Shared PK pattern: students.id IS users.id (class-table inheritance)
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'student_id_number',
        'barcode_value',
        'academic_program',
        'knowledge_score',
        'visit_streak',
        'registration_status',
        'reviewed_by_librarian_id',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(Librarian::class, 'reviewed_by_librarian_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'student_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'student_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'student_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'student_id');
    }

    public function bookSuggestions()
    {
        return $this->hasMany(BookSuggestion::class, 'student_id');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'student_badge', 'student_id', 'badge_id')
            ->withPivot(['trigger_event', 'earned_at']);
    }

    public function pointRedemptions()
    {
        return $this->hasMany(PointRedemption::class, 'student_id');
    }

    public function resourceUsageLogs()
    {
        return $this->hasMany(ResourceUsageLog::class, 'student_id');
    }

    public function isApproved(): bool
    {
        return $this->registration_status === 'approved';
    }
}
