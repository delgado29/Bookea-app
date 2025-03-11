<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'email', 'phone', 'position'];

    // Relación con el negocio
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}