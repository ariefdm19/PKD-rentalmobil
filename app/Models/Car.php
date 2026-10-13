<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_category_id',
        'name',
        'brand',
        'plate_number',
        'year',
        'color',
        'transmission',
        'fuel_type',
        'seating_capacity',
        'price_per_day',
        'penalty_per_hour',
        'image',
        'features',
        'status',
        'description',
    ];

    protected $casts = [
        'year' => 'integer',
        'seating_capacity' => 'integer',
        'price_per_day' => 'decimal:2',
        'penalty_per_hour' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(CarCategory::class, 'car_category_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function maintenances()
    {
        return $this->hasMany(CarMaintenance::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->where('is_published', true)->avg('rating') ?: 5.0;
    }

    public function getFeaturesArrayAttribute(): array
    {
        if (empty($this->features)) {
            return [];
        }
        $decoded = json_decode($this->features, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return array_map('trim', explode(',', $this->features));
    }
}
