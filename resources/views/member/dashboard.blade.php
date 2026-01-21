@extends('member.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<!-- Welcome Message -->
<div class="alert alert-info">
    <h4 class="alert-heading">Welcome, {{ $user->name }}!</h4>
    <p>Welcome to your Diwali Chit Fund account. Track your enrollments and payments here.</p>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Active Enrollments</h6>
                        <h2 class="mb-0">{{ $activeEnrollments }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Paid</h6>
                        <h2 class="mb-0">₹{{ number_format($totalAmountPaid, 2) }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Next Due</h6>
                        <h2 class="mb-0">₹{{ number_format($nextDueAmount, 2) }}</h2>
                        @if($nextDue)
                            <small>Due by {{ $nextDue->format('d M, Y') }}</small>
                        @else
                            <small>No pending dues</small>
                        @endif
                    </div>
                    <div>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Member Since</h6>
                        <h2 class="mb-0">{{ $user->created_at->format('M Y') }}</h2>
                        <small>{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                    <div>
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Payments</h5>
            </div>
            <div class="card-body">
                @if($user->payments()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Receipt No.</th>
                                    <th>Enrollment No.</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->payments()->latest()->limit(5)->get() as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ $payment->enrollment->enrollment_number }}</td>
                                        <td class="fw-bold">₹{{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->payment_mode == 'cash' ? 'success' : ($payment->payment_mode == 'upi' ? 'warning' : 'info') }}">
                                                {{ ucwords(str_replace('_', ' ', $payment->payment_mode)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('member.payments.receipt', $payment) }}" 
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-print"></i> Receipt
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('member.payments.index') }}" class="btn btn-primary">
                            View All Payments <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No payments found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection