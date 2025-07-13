<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeController::class, 'index'])->name('fe.index');
Route::get('profile', [ProfileController::class, 'index'])->name('fe.profile.index');
Route::post('profile', [ProfileController::class, 'update'])->name('fe.profile.update');

Route::get('transaction/{transaction:code}/download', [TransactionController::class, 'download'])->name('fe.transaction.download');
Route::get('transaction/{transaction:code}', [TransactionController::class, 'show'])->name('fe.transaction.detail');

Route::get('carts', [CartController::class, 'index'])->name('fe.cart.index');
Route::post('carts', [CartController::class, 'store'])->name('fe.cart.store');
Route::delete('carts/{cart}', [CartController::class, 'destroy'])->name('fe.cart.destroy');
Route::post('checkout', [CartController::class, 'checkout'])->name('fe.cart.checkout');

Route::post('carts-plus/{cart}', [CartController::class, 'plus'])->name('fe.cart.plus');
Route::post('carts-min/{cart}', [CartController::class, 'min'])->name('fe.cart.min');

Route::get('checkout', function () {
    return redirect()->route('fe.cart.index')->with('error', 'Not Allowed!');
});

Auth::routes();
Route::get('logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
