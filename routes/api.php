<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'auth'])->name('login.auth');

Route::prefix('/users')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::put("/{id}", [UserController::class, 'update'])->name('users.update');
        Route::delete("/{id}", [UserController::class, 'destroy'])->name('users.destroy');
    });
});

Route::prefix('/patients')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/{id}', [PatientController::class, 'show'])->name('patients.show');
        Route::post('/', [PatientController::class, 'store'])->name('patients.store');
        Route::put("/{id}", [PatientController::class, 'update'])->name('patients.update');
        Route::delete("/{id}", [PatientController::class, 'destroy'])->name('patients.destroy');
    });
});