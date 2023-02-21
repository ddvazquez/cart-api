<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Src\Controller\Carts\CartsGetController;
use App\Src\Controller\Carts\CartsPutController;
use App\Src\Controller\Carts\CartsPayPutController;
use App\Src\Controller\CartItems\CartItemsPutController;
use App\Src\Controller\CartItems\CartItemsDeleteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/carts/{cartId}', CartsGetController::class);
Route::put('/carts/{cartId}', CartsPutController::class);
Route::put('/carts/{cartId}/pay', CartsPayPutController::class);

Route::put('/carts/{cartId}/items/{itemId}', CartItemsPutController::class);
Route::delete('/carts/{cartId}/items/{itemId}', CartItemsDeleteController::class);
