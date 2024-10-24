<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\RateController;
use App\Http\Controllers\API\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    /* CHECK API STATUS */
    Route::get('/status', function (Request $request) {
        return response()
            ->json(['version' => 'v1.0.0', 'up' => TRUE]);
    });

    /* API AUTHENTICATION ROUTES */
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class, 'register']);

    /* API PROTECTED ROUTES */
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('logout', [AuthenticationController::class, 'logout']);

        Route::resource('items', ItemController ::class);
        Route::resource('rates', RateController ::class);
        Route::resource('sales', SaleController ::class);
    });
});
