<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfReturnReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'verified_by_librarian_id', 'reported_at', 'verification_status',
    ];

    protected $casts = ['reported_at' => 'datetime'];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Librarian::class, 'verified_by_librarian_id');
    }
}
