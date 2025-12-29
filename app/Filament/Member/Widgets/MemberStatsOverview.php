<?php

namespace App\Filament\Member\Widgets;

use App\Models\Enrollment;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MemberStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        
        $activeEnrollments = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        $totalPaid = Payment::where('user_id', $user->id)
            ->sum('amount');

        $nextDueAmount = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDoesntHave('payments', function ($query) {
                $query->whereMonth('payment_date', now()->month)
                      ->whereYear('payment_date', now()->year);
            })
            ->with('scheme')
            ->get()
            ->sum(fn ($e) => $e->scheme->monthly_amount);

        return [
            Stat::make('Active Enrollments', $activeEnrollments)
                ->description('Current active schemes')
                ->icon('heroicon-o-rectangle-stack'),
            Stat::make('Total Paid', '₹' . number_format($totalPaid, 2))
                ->description('Total savings so far')
                ->icon('heroicon-o-banknotes')
                ->color('success'),
            Stat::make('Next Due', '₹' . number_format($nextDueAmount, 2))
                ->description('Due this month')
                ->icon('heroicon-o-clock')
                ->color($nextDueAmount > 0 ? 'warning' : 'success'),
        ];
    }
}
