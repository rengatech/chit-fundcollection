<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Enrollment;
use App\Models\Payment;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'member') {
            return in_array($this->role, ['admin', 'member']);
        }

        return false;
    }

   protected $fillable = [
    'name',
    'email',
    'mobile',
    'password',
    'role',
    'is_active',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ✅ User has many enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // ✅ User has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
