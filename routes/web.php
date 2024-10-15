<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HomeController;

//Home Routes
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

//Staff Routes
Route::resource('staff', StaffController::class);
Route::view('/staff/shifts', 'staff.shifts');

//Shift Routes
Route::get('/shift', [ShiftController::class, 'index'])
    ->name('shift.index');
Route::get('/shift/create', [ShiftController::class, 'create'])
    ->name('shift.create');
Route::post('/shift', [ShiftController::class, 'store'])
    ->name('shift.store');
Route::get('/shift/{shift}/edit', [ShiftController::class, 'edit'])
    ->name('shift.edit');
Route::put('/shift/{shift}', [ShiftController::class, 'update'])
    ->name('shift.update');
Route::get('/shift/{year}/{month}', [ShiftController::class, 'monthView'])
    ->name('shift.month')
    ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
Route::delete('/shift/{shift}', [ShiftController::class, 'destroy'])
    ->name('shift.destroy');
Route::get('/staff/{staff}/shifts/{year}/{month}', [StaffController::class, 'shift'])
    ->name('staff.shift');
Route::post('/shift/toggle-public-holiday', [ShiftController::class, 'togglePublicHoliday'])
    ->name('shift.togglePublicHoliday');
Route::get('/staff/{staff}/shifts', [StaffController::class, 'wildcard'])
    ->name('staff.wildcard');
Route::get('/shift/details/{date}', [ShiftController::class, 'details'])
    ->name('shift.details');

//Payslip Routes
Route::get('/staff/{staff}/payslip/{month}', [StaffController::class, 'downloadPayslip'])
    ->name('staff.payslip.download');
