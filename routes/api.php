<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrderController;
use App\Http\Resources\OrderItem as OrderItemResource;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/order', [OrderController::class , 'create_order']);

// Route::get('/products', [ProductsController::class , 'index']);
// Route::get('/products/{id}', [ProductsController::class , 'show']);
// Route::post('/products', [ProductsController::class , 'store']);
// Route::patch('/products/{product}', [ProductsController::class , 'update']);
// Route::delete('/products/{id}', [ProductsController::class , 'destroy']);