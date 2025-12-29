<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Filament handles /admin and /member routes automatically.
| Custom backend routes should be added here.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/receipt/{payment}', function (\App\Models\Payment $payment) {
    // Basic security: Check if authorized (Admin or the member who owns the payment)
    if (auth()->guest() || (auth()->user()->role !== 'admin' && auth()->id() !== $payment->user_id)) {
        abort(403);
    }
    return view('reports.receipt', compact('payment'));
})->name('receipt.print')->middleware('auth');
