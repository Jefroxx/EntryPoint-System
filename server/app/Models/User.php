<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'middle_initial',
        'last_name',
        'email',
        'password',
        'phone_number',
        'birth_date',
        'address',
        'user_type',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'id');
    }

    public function librarian()
    {
        return $this->hasOne(Librarian::class, 'id');
    }

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class, 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        $middle = $this->middle_initial ? " {$this->middle_initial}." : '';
        return "{$this->first_name}{$middle} {$this->last_name}";
    }
}
