<?php

namespace App\Filament\Member\Resources;

use App\Models\Payment;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('receipt_number')
                    ->searchable(),
                TextColumn::make('enrollment.enrollment_number')
                    ->label('Enrollment #'),
                TextColumn::make('installment_number')
                    ->label('Installment'),
                TextColumn::make('amount')->money('INR'),
                TextColumn::make('payment_date')->date(),
                TextColumn::make('payment_mode')
                    ->badge(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('print')
                    ->label('Print Receipt')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->url(fn (Payment $record): string => route('receipt.print', $record))
                    ->openUrlInNewTab(),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()));
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Member\Resources\PaymentResource\Pages\ListPayments::route('/'),
        ];
    }
}
