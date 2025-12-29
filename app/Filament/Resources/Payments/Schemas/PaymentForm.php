<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('receipt_number')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder('Auto-generated'),
                Select::make('enrollment_id')
                    ->label('Enrollment')
                    ->relationship('enrollment', 'enrollment_number')
                    ->searchable()
                    ->live()
                    ->required()
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if ($value) {
                                    $enrollment = \App\Models\Enrollment::find($value);
                                    if ($enrollment && $enrollment->paid_installments >= $enrollment->total_installments) {
                                        $fail('All installments for this enrollment are already paid.');
                                    }
                                }
                            };
                        },
                    ])
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $enrollment = \App\Models\Enrollment::with('scheme', 'user')->find($state);
                            if ($enrollment) {
                                $set('user_id', $enrollment->user_id);
                                $set('amount', $enrollment->scheme->monthly_amount);
                                $set('installment_number', $enrollment->paid_installments + 1);
                            }
                        }
                    }),
                Select::make('user_id')
                    ->label('Member')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                TextInput::make('installment_number')
                    ->readonly()
                    ->numeric()
                    ->required(),
                TextInput::make('amount')
                    ->readonly()
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
                DatePicker::make('payment_date')
                    ->default(now())
                    ->required(),
                Select::make('payment_mode')
                    ->options([
                        'cash' => 'Cash',
                        'upi' => 'UPI',
                        'bank_transfer' => 'Bank Transfer',
                    ])
                    ->default('cash')
                    ->required(),
                TextInput::make('reference_number')
                    ->label('Reference Number (UPI/Bank)'),
                Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
