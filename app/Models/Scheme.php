<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'monthly_amount',
        'duration_months',
        'bonus_percentage',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Calculate maturity amount
    public function calculateMaturityAmount()
    {
        $totalAmount = $this->monthly_amount * $this->duration_months;
        $bonusAmount = $totalAmount * ($this->bonus_percentage / 100);
        return $totalAmount + $bonusAmount;
    }
}