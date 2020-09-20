<?php
declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('auth')->group(function(){
    Route::post('login', [\App\Http\Controllers\Auth\ApiAuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Auth\ApiAuthController::class, 'logout']);
});

//Route::middleware('auth:sanctum')->group(function () {

Route::prefix('user')->group(function(){
    Route::get('/', [\App\Http\Controllers\Auth\ApiAuthController::class, 'user']);

    Route::prefix('order')->group(function(){
        Route::get('list', [\App\Http\Controllers\OrderController::class, 'listForCurrentUser']);
        Route::get('{orderId}', [\App\Http\Controllers\OrderController::class, 'index']);
    });

});

//});

Route::get('product/list', [ProductController::class, 'paginate']);

//Route::prefix('user')->middleware('auth:sanctum')->group(function () {
//    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'user']);
//});
