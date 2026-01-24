<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'enrollment_id',
        'user_id',
        'installment_number',
        'amount',
        'payment_date',
        'payment_mode',
        'reference_number',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate receipt number
    public static function generateReceiptNumber()
    {
        $year = date('Y');
        $lastPayment = self::where('receipt_number', 'like', "RCP-{$year}-%")
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->receipt_number, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return "RCP-{$year}-{$newNumber}";
    }
}