<?php
declare(strict_types=1);

use App\Http\Controllers\ProductsController;
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
    Route::get('/user', [\App\Http\Controllers\Auth\ApiAuthController::class, 'user']);
//});

Route::get('product/list', [ProductsController::class, 'index']);

//Route::prefix('user')->middleware('auth:sanctum')->group(function () {
//    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'user']);
//});
