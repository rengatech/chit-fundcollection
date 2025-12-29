<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'monthly_amount',
        'duration_months',
        'bonus_percentage',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Get the enrollments for the scheme.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
