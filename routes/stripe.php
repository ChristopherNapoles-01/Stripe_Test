<?php

use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('stripe', [StripeController::class, 'store']);
