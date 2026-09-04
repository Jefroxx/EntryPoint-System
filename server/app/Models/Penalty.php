<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'penalty_type_id', 'amount',
        'computed_at', 'settled_at', 'payment_status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'computed_at' => 'datetime',
        'settled_at' => 'datetime',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function penaltyType()
    {
        return $this->belongsTo(PenaltyType::class, 'penalty_type_id');
    }
}
