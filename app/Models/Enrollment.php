<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_number',
        'user_id',
        'scheme_id',
        'enrollment_date',
        'total_installments',
        'paid_installments',
        'total_amount',
        'amount_paid',
        'maturity_amount',
        'status',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Generate enrollment number
    public static function generateEnrollmentNumber()
    {
        $year = date('Y');
        $lastEnrollment = self::where('enrollment_number', 'like', "ENR-{$year}-%")
            ->orderBy('enrollment_number', 'desc')
            ->first();

        if ($lastEnrollment) {
            $lastNumber = (int) substr($lastEnrollment->enrollment_number, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return "ENR-{$year}-{$newNumber}";
    }

    
    public function isCompleted()
    {
        return $this->paid_installments >= $this->total_installments;
    }

    
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->amount_paid;
    }

  
    public function getRemainingInstallmentsAttribute()
    {
        return $this->total_installments - $this->paid_installments;
    }
}