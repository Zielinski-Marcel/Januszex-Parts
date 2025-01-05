<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year_of_manufacture',
        'fuel_type',
        'purchase_date',
        'color',
    ];

    protected $casts = [
        'year_of_manufacture' => 'integer',
        'purchase_date' => 'integer',
    ];

    // Relacja wiele-do-wielu z użytkownikami
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vehicle')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    // Relacja jeden-do-wielu z wydatkami
    public function spendings()
    {
        return $this->hasMany(Spending::class);
    }
}
