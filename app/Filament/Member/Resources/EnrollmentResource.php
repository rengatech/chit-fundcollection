<?php

namespace App\Filament\Member\Resources;

use App\Models\Enrollment;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('enrollment_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scheme.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scheme.monthly_amount')
                    ->label('Monthly Pay')
                    ->money('INR'),
                TextColumn::make('paid_installments')
                    ->label('Paid/Total')
                    ->formatStateUsing(fn ($record) => "{$record->paid_installments} / {$record->total_installments}"),
                TextColumn::make('amount_paid')
                    ->label('Paid/Total Amt')
                    ->money('INR')
                    ->formatStateUsing(fn ($record) => "₹".number_format($record->amount_paid)." / ₹".number_format($record->total_amount)),
                TextColumn::make('maturity_amount')
                    ->label('Maturity')
                    ->money('INR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()));
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Member\Resources\EnrollmentResource\Pages\ListEnrollments::route('/'),
        ];
    }
}
