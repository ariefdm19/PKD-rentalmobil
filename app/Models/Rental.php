<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'user_id',
        'car_id',
        'driver_id',
        'start_date',
        'end_date',
        'total_days',
        'car_cost',
        'driver_cost',
        'discount_amount',
        'total_amount',
        'down_payment',
        'remaining_balance',
        'guarantee_type',
        'guarantee_file',
        'pickup_location',
        'dropoff_location',
        'notes',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_days' => 'integer',
        'car_cost' => 'decimal:2',
        'driver_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function returnRecord()
    {
        return $this->hasOne(RentalReturn::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function totalPaid(): float
    {
        return (float) $this->payments()->where('status', 'diterima')->sum('amount');
    }

    public function isFullyPaid(): bool
    {
        return $this->totalPaid() >= (float) $this->total_amount;
    }
}
