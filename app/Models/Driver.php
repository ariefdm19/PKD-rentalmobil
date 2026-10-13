<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'sim_number',
        'daily_rate',
        'status',
        'photo',
        'notes',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
