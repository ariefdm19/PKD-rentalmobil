<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'inspector_id',
        'actual_return_date',
        'delay_hours',
        'delay_penalty',
        'damage_penalty',
        'fuel_penalty',
        'other_penalty',
        'total_penalty',
        'fuel_level_return',
        'condition_status',
        'condition_notes',
        'condition_photo',
        'payment_status',
    ];

    protected $casts = [
        'actual_return_date' => 'datetime',
        'delay_hours' => 'integer',
        'delay_penalty' => 'decimal:2',
        'damage_penalty' => 'decimal:2',
        'fuel_penalty' => 'decimal:2',
        'other_penalty' => 'decimal:2',
        'total_penalty' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
