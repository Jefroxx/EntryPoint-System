<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyType extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    public function rules()
    {
        return $this->hasMany(PenaltyRule::class, 'penalty_type_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'penalty_type_id');
    }
}
