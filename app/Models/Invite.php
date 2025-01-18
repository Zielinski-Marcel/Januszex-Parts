<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitor_id',
        'invitee_id',
        'email',
        'vehicle_id',
        'status',
        'verification_token'
    ];

    /**
     * Get the user who was invited.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }

    /**
     * Get the vehicle associated with the invite.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the user who sent the invite.
     */
    public function invitor()
    {
        return $this->belongsTo(User::class, 'invitor_id');
    }
}
