<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'type',
        'date',
        'place',
        'description',
        'user_id',
        'vehicle_id',
    ];

    protected $casts = [
        'price' => 'float',
        'date' => 'datetime',
    ];

    // Relacja z modelem User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacja z modelem Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
