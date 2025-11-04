<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('employees.index'))->name('dashboard');

    Route::resource('employees', EmployeeController::class)->except(['show']);
    Route::resource('attendance-records', AttendanceRecordController::class)->except(['show']);
    Route::resource('payrolls', PayrollController::class)->only(['index', 'create', 'store', 'destroy']);
});
