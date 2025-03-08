<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    // A schedule entry belongs to a single user (employee)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // And also belongs to a business context
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}