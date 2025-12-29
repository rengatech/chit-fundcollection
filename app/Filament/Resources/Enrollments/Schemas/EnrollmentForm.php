<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('enrollment_number')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder('Auto-generated'),
                Select::make('user_id')
                    ->label('Member')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('scheme_id')
                    ->label('Scheme')
                    ->relationship('scheme', 'name')
                    ->live()
                    ->required()
                    ->rules([
                        function (callable $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                $userId = $get('user_id');
                                if ($userId && $value) {
                                    $exists = \App\Models\Enrollment::where('user_id', $userId)
                                        ->where('scheme_id', $value)
                                        ->where('status', 'active')
                                        ->where('id', '!=', $get('id')) // Ignore current record on edit
                                        ->exists();
                                    
                                    if ($exists) {
                                        $fail('The member already has an active enrollment in this scheme.');
                                    }
                                }
                            };
                        },
                    ])
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $scheme = \App\Models\Scheme::find($state);
                            if ($scheme) {
                                $totalAmount = $scheme->monthly_amount * $scheme->duration_months;
                                $bonusAmount = ($totalAmount * $scheme->bonus_percentage) / 100;
                                
                                $set('total_installments', $scheme->duration_months);
                                $set('total_amount', $totalAmount);
                                $set('maturity_amount', $totalAmount + $bonusAmount);
                            }
                        }
                    }),
                DatePicker::make('enrollment_date')
                    ->default(now())
                    ->required(),
                TextInput::make('total_installments')
                    ->readonly()
                    ->numeric()
                    ->required(),
                TextInput::make('paid_installments')
                    ->readonly()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_amount')
                    ->readonly()
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
                TextInput::make('amount_paid')
                    ->readonly()
                    ->numeric()
                    ->prefix('₹')
                    ->default(0.0),
                TextInput::make('maturity_amount')
                    ->readonly()
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
