<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'service_type',
        'maintenance_date',
        'cost',
        'workshop_name',
        'description',
        'receipt_file',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
