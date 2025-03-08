<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'customer_id',
        'employee_id',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    // An appointment belongs to a business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // The person who booked the appointment
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // The assigned employee
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // If using the pivot table for services:
    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointment_service')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }
}