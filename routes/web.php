<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');
Route::resource('products', ProductController::class)->except('show');
Route::resource('clients', ClientController::class)->except('show');
Route::resource('orders', OrderController::class)->only(['index', 'create', 'store']);
Route::resource('freights', FreightController::class)->except('show');
