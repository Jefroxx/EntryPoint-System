<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyRule extends Model
{
    use HasFactory;

    protected $fillable = ['penalty_type_id', 'rate', 'grace_period_days'];

    protected $casts = ['rate' => 'decimal:2'];

    public function penaltyType()
    {
        return $this->belongsTo(PenaltyType::class, 'penalty_type_id');
    }
}
