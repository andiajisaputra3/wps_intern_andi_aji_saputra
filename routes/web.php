<?php

use App\Http\Controllers\DailyLog\LogController;
use App\Http\Controllers\DailyLog\LogVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\PermissionController;
use App\Http\Controllers\MasterData\RoleController;
use App\Http\Controllers\MasterData\RoleManagementController;
use App\Http\Controllers\MasterData\UserManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'role:admin|manager|direktur|staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'verified', 'role:admin')->group(function () {
    Route::resource('/roles', RoleController::class)->except(['show']);
    Route::resource('/permissions', PermissionController::class)->except(['show']);
    Route::resource('/role-managements', RoleManagementController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('/user-managements', UserManagementController::class)->except(['create', 'store', 'show', 'destroy']);
});

Route::middleware('auth', 'verified', 'role:admin|manager|direktur')->group(function () {
    Route::get('/log-verifications', [LogVerificationController::class, 'index'])->name('log-verifications.index');

    Route::get('/log-verifications/{id}/edit-setuju', [LogVerificationController::class, 'setuju'])->name('verif.setuju');
    Route::put('/log-verifications/{id}/update-setuju', [LogVerificationController::class, 'updateSetuju'])->name('verif.updateSetuju');

    Route::get('/log-verifications/{id}/edit-tolak', [LogVerificationController::class, 'tolak'])->name('verif.tolak');
    Route::put('/log-verifications/{id}/update-tolak', [LogVerificationController::class, 'updateTolak'])->name('verif.updateTolak');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('/logs', LogController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
