<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;

Route::get('/employees/{employee}/schedule', [EmployeeController::class, 'getSchedule']);
Route::get('/employees/available', [EmployeeController::class, 'findAvailable']);
Route::get('/report', [ReportController::class, 'generateReport']);
