<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\AuthenticationHandler;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WastageController;

// Public routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

// Protected routes
Route::middleware([AuthenticationHandler::class])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/account-settings', [AuthController::class, 'showAccountSettings'])->name('account.settings');
    Route::put('/account-settings', [AuthController::class, 'updateAccountSettings'])->name('account.update');

    // Home Routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Crew Routes
    Route::get('/crew/dashboard/{name}', [CrewController::class, 'show'])->name('crew.dashboard');

    // Staff Routes
    Route::resource('staff', StaffController::class);
    Route::view('/staff/shifts', 'staff.shifts');

    // Shift Routes
    Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::get('/shift/today', [ShiftController::class, 'today'])->name('shift.today');
    Route::get('/shift/create', [ShiftController::class, 'create'])->name('shift.create');
    Route::post('/shift', [ShiftController::class, 'store'])->name('shift.store');
    Route::get('/shift/{shift}/edit', [ShiftController::class, 'edit'])->name('shift.edit');
    Route::put('/shift/{shift}', [ShiftController::class, 'update'])->name('shift.update');
    Route::get('/shift/{year}/{month}', [ShiftController::class, 'monthView'])
        ->name('shift.month')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('/shift/clear-month', [ShiftController::class, 'clearMonth'])->name('shift.clear-month');
    Route::get('/shift/week', [ShiftController::class, 'weekView'])->name('shift.week');
    Route::post('/shifts/clear-week', [ShiftController::class, 'clearWeek'])->name('shift.clear-week');
    Route::delete('/shift/{shift}', [ShiftController::class, 'destroy'])->name('shift.destroy');
    Route::get('/staff/{staff}/shifts/{year}/{month}', [StaffController::class, 'shift'])->name('staff.shift');
    Route::post('/shift/toggle-public-holiday', [ShiftController::class, 'togglePublicHoliday'])->name('shift.togglePublicHoliday');
    Route::get('/staff/{staff}/shifts', [StaffController::class, 'wildcard'])->name('staff.wildcard');
    Route::get('/shift/details/{date}', [ShiftController::class, 'details'])->name('shift.details');

    // Payslip Routes
    Route::get('/staff/{staff}/payslip/{month}', [StaffController::class, 'downloadPayslip'])->name('staff.payslip.download');

    // Invoice Routes
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    // Wastage Routes
    Route::get('/wastages/create', [WastageController::class, 'create'])->name('wastages.create');
    Route::post('/wastages', [WastageController::class, 'store'])->name('wastages.store');
    Route::get('/wastages/{wastage}/edit', [WastageController::class, 'edit'])->name('wastages.edit');
    Route::put('/wastages/{wastage}', [WastageController::class, 'update'])->name('wastages.update');
    Route::delete('/wastages/{wastage}', [WastageController::class, 'destroy'])->name('wastages.destroy');
    Route::get('/wastages/{year}/{month}', [WastageController::class, 'details'])
        ->name('wastages.details');

    // Leave Routes
    Route::get('/staff/{staff}/leave', [LeaveController::class, 'index'])->name('staff.leave');
    Route::post('/staff/leave', [LeaveController::class, 'store'])->name('staff.leave.store');
    Route::delete('/staff/leave/{leave}', [LeaveController::class, 'destroy'])->name('staff.leave.destroy');

    // Sales Routes
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    Route::get('/sales/eod/create', [SalesController::class, 'createEod'])->name('sales.createEod');
    Route::post('/sales/eod', [SalesController::class, 'storeEod'])->name('sales.storeEod');
    Route::get('/sales/eod/{id}/edit', [SalesController::class, 'editEod'])->name('sales.editEod');
    Route::put('/sales/eod/{id}/{cumu_id}', [SalesController::class, 'updateEod'])->name('sales.updateEod');

    Route::get('/sales/bankin/create', [SalesController::class, 'createBankin'])->name('sales.createBankin');
    Route::post('/sales/bankin', [SalesController::class, 'storeBankin'])->name('sales.storeBankin');
    Route::get('/sales/bankin/{id}/edit', [SalesController::class, 'editBankin'])->name('sales.editBankin');
    Route::put('/sales/bankin/{id}/{cumu_id}', [SalesController::class, 'updateBankin'])->name('sales.updateBankin');

    Route::get('/sales/earning/create', [SalesController::class, 'createEarning'])->name('sales.createEarning');
    Route::post('/sales/earning', [SalesController::class, 'storeEarning'])->name('sales.storeEarning');
    Route::get('/sales/earning/{id}/edit', [SalesController::class, 'editEarning'])->name('sales.editEarning');
    Route::put('/sales/earning/{id}/{cumu_id}', [SalesController::class, 'updateEarning'])->name('sales.updateEarning');

    Route::get('/sales/expense/create', [SalesController::class, 'createExpense'])->name('sales.createExpense');
    Route::post('/sales/expense', [SalesController::class, 'storeExpense'])->name('sales.storeExpense');
    Route::get('/sales/expense/{id}/edit', [SalesController::class, 'editExpense'])->name('sales.editExpense');
    Route::put('/sales/expense/{id}/{cumu_id}', [SalesController::class, 'updateExpense'])->name('sales.updateExpense');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/part-time-details', [ReportController::class, 'partTimeDetails'])->name('reports.part-time-details');
});

