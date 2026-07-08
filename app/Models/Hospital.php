<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hospital extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'hospital_name',
        'email',
        'password',
        'address',
        'location',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function notifications(): HasMany
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable');
    }
}
