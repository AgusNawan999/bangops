<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OperationsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ops/status', [OperationsController::class, 'status']);
    Route::post('/ops/execute', [OperationsController::class, 'execute']);
});