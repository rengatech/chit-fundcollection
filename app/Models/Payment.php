<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->receipt_number)) {
                $latest = static::latest('id')->first();
                $nextId = $latest ? $latest->id + 1 : 1;
                $model->receipt_number = 'RCP-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($model) {
            $enrollment = $model->enrollment;
            $enrollment->paid_installments = $enrollment->payments()->count();
            $enrollment->amount_paid = $enrollment->payments()->sum('amount');
            
            if ($enrollment->paid_installments >= $enrollment->total_installments) {
                $enrollment->status = 'completed';
            }
            
            $enrollment->save();
        });
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
