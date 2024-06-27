<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SchedulingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\VaccineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'auth'])->name('login.auth');
Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
    Route::get('/infos', [InfoController::class, 'index'])->name('infos.index');
});

Route::prefix('/users')->group(function () {
    Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
        Route::get('/professionals', [UserController::class, 'listProfessionals'])->name('users.listProfessionals');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put("/{id}", [UserController::class, 'update'])->name('users.update');
        Route::delete("/{id}", [UserController::class, 'destroy'])->name('users.destroy');
    });
});

Route::prefix('/patients')->group(function () {
    Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
        Route::post('/', [PatientController::class, 'store'])->name('patients.store');
        Route::get('/', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/{id}', [PatientController::class, 'show'])->name('patients.show');
        Route::put("/{id}", [PatientController::class, 'update'])->name('patients.update');
        Route::delete("/{id}", [PatientController::class, 'destroy'])->name('patients.destroy');
    });
});

Route::prefix('/employees')->group(function () {
    Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
        Route::put("/{id}", [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete("/{id}", [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });
});

Route::prefix('/vaccines')->group(function () {
    Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
        Route::get('/', [VaccineController::class, 'index'])->name('vaccines.index');
        Route::get('/{id}', [VaccineController::class, 'show'])->name('vaccines.show');
        Route::post('/', [VaccineController::class, 'store'])->name('vaccines.store');
        Route::put("/{id}", [VaccineController::class, 'update'])->name('vaccines.update');
        Route::delete("/{id}", [VaccineController::class, 'destroy'])->name('vaccines.destroy');
    });
});

Route::prefix('/schedulings')->group(function () {
    Route::middleware(['auth:sanctum', 'extract.user.id'])->group(function () {
        Route::get('/', [SchedulingController::class, 'index'])->name('schedulings.index');
        Route::get('/{id}', [SchedulingController::class, 'show'])->name('schedulings.show');
        Route::post('/', [SchedulingController::class, 'store'])->name('schedulings.store');
        Route::put("/{id}", [SchedulingController::class, 'update'])->name('schedulings.update');
    });
});

Route::prefix('/status')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [StatusController::class, 'index'])->name('status.index');
        Route::post('/', [StatusController::class, 'store'])->name('status.store');
    });
});
