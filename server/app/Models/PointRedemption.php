<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'item_id', 'points_spent', 'fulfillment_status', 'redeemed_at',
    ];

    protected $casts = ['redeemed_at' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function item()
    {
        return $this->belongsTo(MarketItem::class, 'item_id');
    }
}
