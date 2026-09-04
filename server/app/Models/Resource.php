<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = ['resource_type', 'name', 'status'];

    public function usageLogs()
    {
        return $this->hasMany(ResourceUsageLog::class, 'res_id');
    }
}
