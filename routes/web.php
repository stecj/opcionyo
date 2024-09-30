<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/employee/schedule', [EmployeeController::class, 'scheduleForm'])->name('employee.schedule');
Route::get('/employee/available', [EmployeeController::class, 'availableForm'])->name('employee.available');
Route::get('/report', [ReportController::class, 'generateForm'])->name('report.generate');
Route::get('/report/download', [ReportController::class, 'generateReport'])->name('report.download');
Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
