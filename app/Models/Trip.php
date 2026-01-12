<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_city',
        'to_city',
        'departure_at',
        'price',
        'capacity',
        'available_seats',
        'status'
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
