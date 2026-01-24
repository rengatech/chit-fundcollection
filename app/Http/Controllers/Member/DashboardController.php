<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $activeEnrollments = $user->enrollments()->where('status', 'active')->count();
        $totalAmountPaid = $user->payments()->sum('amount');
        
        // Calculate next due
        $nextDue = null;
        $nextDueAmount = 0;
        
        $activeEnrollment = $user->enrollments()
            ->where('status', 'active')
            ->whereColumn('paid_installments', '<', 'total_installments')
            ->first();
        
        if ($activeEnrollment) {
            $nextDueAmount = $activeEnrollment->scheme->monthly_amount;
            $nextDue = now()->addMonth()->startOfMonth();
        }
        
        return view('member.dashboard', compact(
            'user',
            'activeEnrollments',
            'totalAmountPaid',
            'nextDue',
            'nextDueAmount'
        ));
    }
}