<?php

use App\Http\Controllers\Api\CashierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('products', [CashierController::class, 'getListProduct']);
Route::get('customers', [CashierController::class, 'getCustomer']);
Route::post('customer', [CashierController::class, 'storeCustomer']);
Route::get('order/{id}/detail', [CashierController::class, 'getOrderDetailCustomer']);
Route::delete('customer/{id}/delete', [CashierController::class, 'deleteCustomer']);
Route::post('checkout-order', [CashierController::class, 'storeOrder']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
