<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Payment;

class StatsOverview extends StatsOverviewWidget
{
    // Optional: auto-refresh interval in seconds
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Active Members', User::where('is_active', true)
                ->where('role', 'member')
                ->count())
                ->description('Total active members'),

            Stat::make('Active Enrollments', Enrollment::where('status', 'active')->count())
                ->description('Total active enrollments'),

            Stat::make(
                'This Month Collection',
                '₹' . number_format(
                    Payment::whereMonth('payment_date', now()->month)
                        ->whereYear('payment_date', now()->year)
                        ->sum('amount'),
                    2
                )
            )
            ->description('Total collection this month'),

            Stat::make(
                'Pending Payments',
                Enrollment::where('status', 'active')
                    ->whereColumn('paid_installments', '<', 'total_installments')
                    ->count()
            )
            ->description('Enrollments with pending payments'),
        ];
    }
}
