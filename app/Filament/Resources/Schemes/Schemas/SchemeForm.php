<?php

namespace App\Filament\Resources\Schemes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SchemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('e.g., Gold Scheme 2025'),
                TextInput::make('monthly_amount')
                    ->label('Monthly Installment')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                Select::make('duration_months')
                    ->label('Duration (Months)')
                    ->options([
                        6 => '6 Months',
                        9 => '9 Months',
                        12 => '12 Months',
                    ])
                    ->required(),
                Select::make('bonus_percentage')
                    ->label('Bonus Percentage')
                    ->options([
                        10 => '10%',
                        15 => '15%',
                        20 => '20%',
                    ])
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
