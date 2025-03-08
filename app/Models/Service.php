<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'description',
        'price',
        'duration',
    ];

    // Service belongs to a business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // If you have a pivot table for appointment_service:
    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_service')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }
}