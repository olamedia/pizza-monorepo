<?php
declare(strict_types=1);

use App\Http\Controllers\ProductController;
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
Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\ApiAuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Auth\ApiAuthController::class, 'logout']);
});

//Route::middleware('auth:sanctum')->group(function () {
Route::prefix('user')->group(function () {
    Route::get('/', [\App\Http\Controllers\Auth\ApiAuthController::class, 'user']);

    Route::get('cart', [\App\Http\Controllers\CartItemController::class, 'listForCurrentUser']);
    Route::post('cart', [\App\Http\Controllers\CartItemController::class, 'replaceForCurrentUser']);

    Route::prefix('order')->group(function () {
        Route::get('list', [\App\Http\Controllers\OrderController::class, 'listForCurrentUser']);
        Route::get('{orderId}', [\App\Http\Controllers\OrderController::class, 'index']);
    });
});

Route::get('currency', function(\Illuminate\Http\Request $request){
    return \response()->json([
        'USD' =>  1,
        'EUR' => 1.1767
    ]);
});
//});

Route::prefix('product')->group(function () {
    Route::get('list', [ProductController::class, 'paginate']);
});



//Route::prefix('user')->middleware('auth:sanctum')->group(function () {
//    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'user']);
//});
