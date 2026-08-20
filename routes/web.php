<?php

use Illuminate\Support\Facades\Route;
// registrasi alamat file AdminController beserta dengan alamat folder
use App\Http\Controllers\AdminController;
// registrasi alamat file CashierController beserta dengan alamat folder
use App\Http\Controllers\CashierController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    // ====== ROUTE FOR ADMIN =======
    Route::get('admin-dashboard', [AdminController::class, 'index'])->name('admin-dashboard');

    Route::view('profits', 'admin.profits.index')->name('profits');
    // route untuk mengambil list-product
    Route::get('list-product', [AdminController::class, 'getListProduct'])->name('list-product');

    // mengirim data ke BE
    Route::post('store-product', [AdminController::class, 'storeProduct'])->name('store-product');

    // route untuk melakukan delete product dan stock
    Route::delete('product/{productId}/delete', [AdminController::class, 'deleteProduct'])->name('product.delete');

    // jalur mengambil data product berdasarkan productId
    Route::get('data-product-by/{productId}', [AdminController::class, 'getProductById'])
        ->name('data-product-by');

    Route::get('product/{productId}/edit', [AdminController::class, 'getProduct'])->name('product.edit');

    Route::post('product/{productId}/restock', [AdminController::class, 'restockProduct'])->name('product.restock');

    // route untuk melakukan store data demo create produk
    Route::post('demo-store-product', [AdminController::class, 'demoStoreDataProduct'])->name('demo-store-product');

    // route untuk melakukn penghapusan demo delete produk
    Route::delete('demo-delete-product/{productId}', [AdminController::class, 'demoDeleteProduct'])->name('demo-delete-product');


    // ROUTES FOR CASHIER
    Route::get('cashier-dashboard', [CashierController::class, 'index'])->name('cashier-dashboard');
});


require __DIR__.'/auth.php';
