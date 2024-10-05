<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::view('/', 'home');
Route::resource('staff', StaffController::class);
