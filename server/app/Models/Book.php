<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'call_number',
        'accession_number',
        'cover_image_url',
        'shelf_location',
        'total_copies',
        'available_copies',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author', 'book_id', 'author_id')
            ->withPivot('role');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'book_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'book_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'book_id');
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }
}
