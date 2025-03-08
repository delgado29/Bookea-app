<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // For Auth
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    // Eloquent relationships:

    // Each User belongs to one Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // A User may own many Businesses (if they are business_admin)
    public function ownedBusinesses()
    {
        return $this->hasMany(Business::class, 'owner_id');
    }

    // Many-to-Many relationship with businesses
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_user')
                    ->withTimestamps()
                    ->withPivot('position'); 
    }

    // A User (if role=employee) can have multiple schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // A User (if role=customer) can have many appointments
    public function appointmentsAsCustomer()
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    // A User (if role=employee) can also have many appointments
    public function appointmentsAsEmployee()
    {
        return $this->hasMany(Appointment::class, 'employee_id');
    }
}