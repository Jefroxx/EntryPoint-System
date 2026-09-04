<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'point_cost', 'stock'];

    public function redemptions()
    {
        return $this->hasMany(PointRedemption::class, 'item_id');
    }

    public function inStock(): bool
    {
        return $this->stock > 0;
    }
}
