<?php

use App\Http\Controllers\Api\Projects\ProjectReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/projects/report', [ProjectReportController::class, 'index']);
});
