<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'user_vehicle')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function spendings(): HasMany
    {
        return $this->hasMany(Spending::class);
    }

    public function vehicle(): HasMany
    {
        return $this->hasMany(Vehicle::class,'owner_id');
    }

    public function lastSpendings()
    {
        $vehicles = $this->vehicles()->select('vehicles.id')->get()->pluck('id');
        $spendings = Spending::query()->whereIn('vehicle_id', $vehicles)->orderBy('updated_at')->limit(10)->get();
        $spendings = $spendings->sortBy(function (Spending $spending) {
            return $spending->updated_at->timestamp;
        });

        return $spendings;
    }
}
