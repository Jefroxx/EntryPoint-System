<?php

use App\Http\Controllers\Admin\LibrarianAccountController;
use App\Http\Controllers\Admin\StudentApprovalController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register/student', [StudentRegistrationController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Librarian/admin-only routes — replace 'librarian' with your actual
    // gate/middleware name once role-based middleware is set up (Phase 1 TODO)
    Route::middleware('role:librarian')->prefix('admin')->group(function () {
        Route::post('/librarians', [LibrarianAccountController::class, 'store']);
        Route::get('/students/pending', [StudentApprovalController::class, 'index']);
        Route::patch('/students/{student}/review', [StudentApprovalController::class, 'update']);
    });
});
