<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/parse', [\App\Http\Controllers\ParseController::class, 'parse']);
