<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:6,1')->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/book', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/book', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/documents', [DashboardController::class, 'storeDocument'])->name('documents.store');
    Route::get('/documents/{document}/download', [DashboardController::class, 'downloadDocument'])->name('documents.download');
    Route::delete('/documents/{document}', [DashboardController::class, 'destroyDocument'])->name('documents.destroy');
    Route::post('/service-requests', [DashboardController::class, 'storeServiceRequest'])->name('service-requests.store');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');
    Route::patch('/appointments/{appointment}', [AdminController::class, 'updateAppointment'])->name('appointments.update');
    Route::patch('/requests/{serviceRequest}', [AdminController::class, 'updateRequest'])->name('requests.update');
});
