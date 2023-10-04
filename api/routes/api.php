<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Customer\FoodSessionController;
use App\Http\Controllers\Customer\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



/** Customer Routes */
Route::post('/customer/login', [AuthenticatedSessionController::class, 'login'])
    ->middleware('guest:customer')
    ->name('api.customer.login');

Route::post('/customer/logout', [AuthenticatedSessionController::class, 'logout'])
    ->middleware('auth:customer')
    ->name('api.customer.logout');

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/user', fn (Request $request) => $request->user());
});

Route::get('/customer/food_sessions', [FoodSessionController::class, 'index']);
Route::get('/customer/food_sessions/{foodSession}', [FoodSessionController::class, 'show']);
