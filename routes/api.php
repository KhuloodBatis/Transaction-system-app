<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\RegisterController as CustomerRegisterController;
use App\Http\Controllers\Customer\TransactionController as ShowTransationController;

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
Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

    Route::prefix('admin')->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('roles', [RoleController::class, 'store']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('transactions', [TransactionController::class, 'index']);
            Route::post('transactions', [TransactionController::class, 'store']);
            Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
            Route::post('categories', [CategoryController::class, 'store']);
            Route::post('subcategories', [SubcategoryController::class, 'store']);
            Route::get('categories/{category}', [CategoryController::class, 'show']);
            Route::post('reports',[ReportController::class,'store']);
            Route::get('reports',[ReportController::class,'index']);
            Route::get('payments', [PaymentController::class, 'index'])->withoutMiddleware('role:admin');
            Route::post('payments', [PaymentController::class, 'store']);
    });
});

    Route::prefix('customer')->group(function () {
        Route::post('register', [CustomerRegisterController::class, 'register']);
        Route::middleware('auth:sanctum')->group(function () {
        Route::get('transactions/{transaction}', [ShowTransationController::class, 'show']);
    });
});



