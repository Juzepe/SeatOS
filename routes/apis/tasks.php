<?php

use App\Http\Controllers\Api\Tasks\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
});
