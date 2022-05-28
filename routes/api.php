<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\RegisterController as CustomerRegisterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('roles', [RoleController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('add-transactions', [TransactionController::class, 'store']);
        Route::get('show-transactions/{transaction}', [TransactionController::class, 'show']);
        Route::post('add-categories', [CategoryController::class, 'store']);
        Route::get('show-categories/{category}', [CategoryController::class, 'show']);
    });
});

Route::prefix('customer')->group(function () {
    Route::post('register', [CustomerRegisterController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('show-categories/{category}', [CategoryController::class, 'show']);
        Route::post('payments', [PaymentController::class, 'store']);
    });
});
