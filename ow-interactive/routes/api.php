<?php

use App\Http\Controllers\Client\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisterController::class, 'handle']);
