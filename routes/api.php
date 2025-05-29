<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\JenisParametersController;
use App\Http\Controllers\JenisWorkPermitController;
use App\Http\Controllers\PermitToWorkController;
use App\Http\Controllers\WorkPermitController;
use App\Models\JenisPtw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserController::class);
    Route::post('/permit-to-work', [PermitToWorkController::class, 'store']);

    Route::get('/permit-types', function() {
        return JenisPtw::all();
    });

    Route::apiResource('jenis-work-permits', JenisWorkPermitController::class);
    Route::apiResource('jenis-parameters', JenisParametersController::class);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout']);