<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;

Route::middleware('auth.basic')->apiResource('services', ServiceController::class);
