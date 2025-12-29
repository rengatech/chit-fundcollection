<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->enrollment_number)) {
                $latest = static::latest('id')->first();
                $nextId = $latest ? $latest->id + 1 : 1;
                $model->enrollment_number = 'ENR-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

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
}
