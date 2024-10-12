<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShiftController;

Route::view('/', 'home');

Route::resource('staff', StaffController::class);
Route::view('/staff/shifts', 'staff.shifts');

Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
Route::get('/shift/{year}/{month}', [ShiftController::class, 'monthView'])->name('shift.month');
Route::get('/shift/create', [ShiftController::class, 'create'])->name('shift.create');
Route::post('/shift', [ShiftController::class, 'store'])->name('shift.store');