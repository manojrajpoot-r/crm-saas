<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Tenant\AttendanceController;
use App\Http\Controllers\API\Tenant\AuthController;
use App\Http\Controllers\API\Tenant\ShiftController;
use Illuminate\Http\Request;


    Route::post('login', [AuthController::class, 'login']);


  Route::middleware(['tenant','auth:api'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('shifts', ShiftController::class);
        Route::apiResource('attendances', AttendanceController::class);
        Route::post('attendance/check-out', [AttendanceController::class, 'checkOut']);

     });
