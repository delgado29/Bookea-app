<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'phone',
        'description',
    ];

    // A Business belongs to one "owner" user
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'business_user')
                    ->where('role_id', 3) // Solo empleados
                    ->withTimestamps();
    }
    // A Business has many services
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Many-to-Many relationship with users (employees, etc.)
    public function users()
    {
        return $this->belongsToMany(User::class, 'business_user')
                    ->withTimestamps()
                    ->withPivot('position');
    }

    // A Business has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}