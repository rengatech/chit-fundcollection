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

use App\Http\Controllers\AuthController;
use App\Models\Payment;

Route::get('/', function () {
    return view('Home');
})->name('home');

Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

Route::post('/custom-login', [AuthController::class, 'login'])->name('custom.login');
Route::post('/custom-signup', [AuthController::class, 'register'])->name('custom.signup');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/receipt/{payment}', function (Payment $payment) {
    // Basic security: Check if authorized (Admin or the member who owns the payment)
    if (auth()->guest() || (auth()->user()->role !== 'admin' && auth()->id() !== $payment->user_id)) {
        abort(403);
    }
    return view('reports.receipt', compact('payment'));
})->name('receipt.print')->middleware('auth');
