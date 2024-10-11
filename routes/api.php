<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
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


Route::post('/transaction/start', [PaymentController::class, 'startTransaction']);
Route::post('/transaction/update', [PaymentController::class, 'updateTransaction']);
Route::post('/transaction/complete', [PaymentController::class, 'completeTransaction']);
Route::post('/transaction/cancel', [PaymentController::class, 'cancelTransaction']);
Route::get('/transaction/status', [PaymentController::class, 'checkTransactionStatus']);


// QUẢN LÝ DỰ ÁN

Route::apiResource('projects', ProjectController::class);

// Quản lý nhiệm vụ trong dự án (Nested Routes)
Route::prefix('projects/{project}')->group(function () {
    Route::apiResource('tasks', TaskController::class)->shallow();
});